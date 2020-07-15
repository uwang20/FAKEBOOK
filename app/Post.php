<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }


    public function comments(){
        return $this->morphMany(Comment::class, 'commentable');
    }

    // REACTS

    public function usersReacts(){
      return $this->belongsToMany(User::class)
                  ->withTimestamps()
                  ->withPivot(['react']);
    }

    public function getReactCount($react){
      return $this->belongsToMany(User::class)
                  ->withPivot(['react'])
                  ->wherePivot('react', $react);
    }

    // public function usersLikes(){
    //   return $this->getReactCount('Like')->count();
    // }
    // public function usersLoves(){
    //   return $this->getReactCount('Love')->count();
    // }
    // public function usersCares(){
    //   return $this->getReactCount('Care')->count();
    // }
    // public function usersHahas(){
    //   return $this->getReactCount('Haha')->count();
    // }
    // public function usersWows(){
    //   return $this->getReactCount('Wow')->count();
    // }
    // public function usersSads(){
    //   return $this->getReactCount('Sad')->count();
    // }
    // public function usersAngries(){
    //   return $this->getReactCount('Angry')->count();
    // }

}
