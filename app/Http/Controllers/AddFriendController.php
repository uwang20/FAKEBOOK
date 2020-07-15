<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class AddFriendController extends Controller
{
    public function store(User $user){
      if($user->id == auth()->user()->id){
        return redirect()->route('users.index',$user->id);
      }
        return auth()->user()->requestsToBeFriend()->toggle($user->profile);
    }

    public function destroy(User $user){
        if($user->requestsToBeFriend->contains(auth()->user()->id)){
            return $user->requestsToBeFriend()->toggle(auth()->user()->profile);
        }
        else if($user->profile->peopleWantToBeYourFriend->contains(auth()->user()->id)){
            return $user->profile->peopleWantToBeYourFriend()->toggle(auth()->user()->profile);
        }

        return $user->requestsToBeFriend()->toggle(auth()->user()->profile);
    }

    public function confirm(User $user){
        return $user->requestsToBeFriend()->updateExistingPivot(auth()->user()->id, ['are_friend' => true]);;
    }
}
