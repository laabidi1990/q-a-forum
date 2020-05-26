<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use VotableTrait;

    protected $guarded = [];

    protected $appends = ['is_favorited', 'favorites_count', 'created_date', 'body_html'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class)->orderBy('created_at', 'DESC');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttribute()
    {
        // return route('questions.show', str_limit($this->slug, 20, 'title'));
        return route('questions.show', $this->slug);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getStatusAttribute()
    {   
        if($this->answers_count > 0)
        {
            if($this->best_answer_id)
            {
                return "answered-accepted";
            }

            return "answered";
        }

        return "anaswered";
    }

    public function getBodyHtmlAttribute()
    {
        $parsedown = new \Parsedown();
        return $parsedown->text(strip_tags($this->body));
    }

    public function addBestAnswer(Answer $answer)
    {
        $this->update([
            'best_answer_id' => $answer->id,
        ]);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', Auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();    
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

}
