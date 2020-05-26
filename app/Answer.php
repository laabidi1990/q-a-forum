<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    
    use VotableTrait;

    protected $guarded = [];

    protected $appends = ['body_html', 'answer_status', 'created_date'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($answer) {
            $answer->question->increment('answers_count');
        });

        static::deleted(function($answer) {
            $answer->question->decrement('answers_count');
        });
    }

    public function getAnswerStatusAttribute()
    {
        if ($this->question->best_answer_id === $this->id) {
            return true;
        }
        else {
            return false;
        }   
    }

    public function getBodyHtmlAttribute()
    {
        $parsedown = new \Parsedown();
        return $parsedown->text(strip_tags($this->body));
    }

}
