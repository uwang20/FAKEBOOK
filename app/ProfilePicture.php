<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilePicture extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function usersReacts(){
      return $this->belongsToMany(User::class)
                  ->withTimestamps()
                  ->withPivot(['react']);
    }

    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }
}
