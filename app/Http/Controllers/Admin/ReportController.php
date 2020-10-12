<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\{Quiz, QuizPlayed};
use App\User;
use DB;

class ReportController extends Controller
{
    public function quizzesPlayed()
    {
        $sortBy = request()->sort_by ?? 'id';
        $sortOrder = request()->sort_order ?? 'DESC';

        $quizzesPlayed = QuizPlayed::query()
            ->with('user:id,name,email')
            ->when(request()->user, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'LIKE', '%' . request()->user . '%')
                        ->orWhere('email', 'LIKE', '%' . request()->user . '%');
                });
            })
            ->when(request()->status, function ($query) {
                $query->where('status', request()->status);
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(20);

        return view('admin/quiz-index', compact('quizzesPlayed'));
    }

    public function quizSummary($playedId)
    {
        $quizPlayed = QuizPlayed::query()
            ->with([
                'user:id,name', 
                'playSummary.quiz:id,question',
            ])
            ->findOrFail($playedId);

        return view('admin/quiz-summary', compact('quizPlayed'));
    }

    public function allUsers()
    {
        $sortBy = request()->sort_by ?? 'id';
        $sortOrder = request()->sort_order ?? 'DESC';

        $users = User::query()
            ->withCount([
                'quizPlayed' => function ($query) {
                    $query->where('status', 'complete');
                },
                'quizPlayed as avg_points' => function ($query) {
                    $query->select(DB::raw('ROUND(AVG(scored_points), 2)'))
                        ->where('status', 'complete');
                }
            ])
            ->when(request()->name, function ($query) {
                $query->where('name', 'LIKE', '%' . request()->name . '%');
            })
            ->when(request()->email, function ($query) {
                $query->where('email', 'LIKE', '%' . request()->email . '%');
            })
            ->orderBy($sortBy, $sortOrder)
            ->paginate(20);

        return view('admin/users-all', compact('users'));
    }

    public function user($userId)
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
            ->findOrFail($userId);

        return view('admin/user', compact('user'));
    }

}
