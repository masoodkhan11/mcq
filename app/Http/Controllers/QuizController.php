<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Quiz, QuizPlayed};
use App\User;
use GuzzleHttp\Client;
use DB;

class QuizController extends Controller
{
    public function index()
    {
    	$client = new Client;

    	$response = $client->get('https://opentdb.com/api.php?amount=10');
    	$stream = json_decode($response->getBody()->getContents(), true);
    	
    	if (empty($stream['results'])) {
    		return redirect()->route('home');
    	}

    	$quizPlayed = auth()->user()->quizPlayed()->create([
            'total_points' => count($stream['results']),
        ]);

        $quizData = array_map(function ($value) use ($quizPlayed) {
            $value['incorrect_answers'] = json_encode($value['incorrect_answers']);
            $value['played_id'] = $quizPlayed->id;
            return $value;
        }, $stream['results']);

        Quiz::insert($quizData);

        $quiz = $quizPlayed->quiz;
    	
    	return view('quiz/index', compact('quizPlayed', 'quiz'));
    }

    public function submit($playedId)
    {
    	$quizPlayed = QuizPlayed::inComplete()
            ->whereUserId(auth()->id())
            ->findOrFail($playedId);

        request()->validate([
            'answers' => ['required', 'array'],
        ]);

        $quizIds = array_keys(request()->answers);

        $quiz = Quiz::whereIn('id', $quizIds)
            ->wherePlayedId($playedId)
            ->get();

        $playedData = [];
        $pointsScored = 0;

        foreach ($quiz as $question) {
            $answer = request()->answers[$question->id];
            $isCorrect = ($answer == $question->correct_answer) ? 1 : 0;
            $pointsScored += $isCorrect;

            $playedData[] = [
                'quiz_id' => $question->id,
                'answer' => $answer,
                'is_correct' => $isCorrect,
            ];
        }

        try {
            DB::beginTransaction();
            
            $playSummary = $quizPlayed->playSummary()->createMany($playedData);
            $quizPlayed->completeQuiz($pointsScored);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
        }
        
        return redirect()->route('quiz.result', $quizPlayed);
    }

    public function result($playedId)
    {
        $quizPlayed = QuizPlayed::query()
            ->with('playSummary')
            ->complete()
            ->whereUserId(auth()->id())
            ->findOrFail($playedId);

        return view('quiz/result', compact('quizPlayed'));
    }


    public function user()
    {
        $user = User::query()
            ->withCount([
                'quizPlayed' => function ($query) {
                    $query->where('status', 'complete');
                },
                'quizPlayed as avg_points' => function ($query) {
                    $query->select(DB::raw('ROUND(AVG(scored_points), 2)'))
                        ->where('status', 'complete');
                }
            ])
            ->with('quizPlayed')
            ->findOrFail(auth()->id());

        return view('quiz.user-activity', compact('user'));
    }
}
