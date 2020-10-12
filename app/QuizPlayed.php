<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizPlayed extends Model
{
    protected $table = 'quiz_played';

    protected $fillable = [
    	'user_id', 'status', 'total_points', 'scored_points'
    ];

    protected $attributes = [
    	'status' => 'incomplete',
    	'scored_points' => 0,
    ];


    public function scopeComplete($query)
    {
        return $query->where('status', 'complete');
    }

    public function scopeInComplete($query)
    {
        return $query->where('status', 'incomplete');
    }


    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function quiz()
    {
    	return $this->hasMany('App\Quiz', 'played_id');
    }

    public function playSummary()
    {
        return $this->hasMany('App\QuizPlaySummary', 'played_id');
    }


    public function completeQuiz($pointsScored)
    {
        $this->scored_points = $pointsScored;
        $this->status = 'complete';
        $this->save();
    }

    public function getStatusHtml()
    {
        if ($this->status == 'complete') {
            return '<b class="text-success">Complete</b>';
        }

        return '<b class="text-danger">InComplete</b>';
    }
}
