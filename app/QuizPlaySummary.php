<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizPlaySummary extends Model
{
    protected $table = 'quiz_play_summary';

    protected $fillable = [
    	'played_id', 'quiz_id', 'answer', 'is_correct'
    ];


    public function played()
    {
    	return $this->belongsTo('App\QuizPlayed', 'played_id');
    }

    public function quiz()
    {
    	return $this->belongsTo('App\Quiz', 'quiz_id');
    }


    public function getStatusHtml()
    {
        if ($this->is_correct) {
            return '<b class="text-success">True</b>';
        }

        return '<b class="text-danger">False</b>';
    }
}
