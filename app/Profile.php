<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function peopleWantToBeYourFriend(){
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->withPivot(['are_friend']);
    }

    public function confirmedFriends(){
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->withPivot(['are_friend'])
                    ->wherePivot('are_friend', true);
    }

    public function friendRequests(){
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->withPivot(['are_friend'])
                    ->wherePivot('are_friend', false);       
    }



    public function grantedFriendRequests(){
        return $this->belongsToMany(User::class);
                   
    }

}
