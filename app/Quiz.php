<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
    	'played_id', 'category', 'type', 'difficulty', 
    	'question', 'correct_answer', 'incorrect_answers'
    ];

    protected $casts = [
    	'incorrect_answers' => 'array',
    ];


    public function played()
    {
    	return $this->belongsTo('App\QuizPlayed', 'played_id');
    }

}
