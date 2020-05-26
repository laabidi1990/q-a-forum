<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Thomaswelton\LaravelGravatar\Facades\Gravatar;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends= ['url', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getUrlAttribute()
    {
        // return route('questions.show', $this->id);
        return "#";
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps();
    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable')->withTimestamps();;
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable')->withTimestamps();;
    }

    public function voteTheQuestion(Question $question, $vote)
    {
        $voteQuestions = $this->voteQuestions();
        return $this->_vote($voteQuestions, $question, $vote);
    }

    public function voteTheAnswer(Answer $answer, $vote)
    {
        $voteAnswers = $this->voteAnswers();
        return $this->_vote($voteAnswers, $answer, $vote);
     
    }

    private function _vote($relationShip, $model, $vote)
    {
        if ($relationShip->where('votable_id', $model->id)->exists()) {
            $relationShip->updateExistingPivot($model, ['vote' => $vote]);
        }
        else {
            $relationShip->attach($model, ['vote' => $vote]);
        }

        $model->load('votes');
        $downVote = (int) $model->downVote()->sum('vote');
        $upVote = (int) $model->upVote()->sum('vote');

        $model->votes_count = $downVote + $upVote;
        $model->save();
        
        return $model->votes_count;
    }

    public function getAvatarAttribute()
    {
        return Gravatar::src($this->email);
    }
}
