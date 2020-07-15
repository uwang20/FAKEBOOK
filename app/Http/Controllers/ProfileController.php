<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function index(User $user)
    {
      // dd($user->getModifiedUsersPosts()[1]['comments'][1]['comment']);
        // dd($user->getModifiedCoverPhoto());
        // $mod = collect($user->getModifiedProfilePictures())->map(function ($prof){
        //   return collect($prof)->merge([
        //     'images' => [['image' => $prof['profile_picture']]],
        //     'body' => $prof['caption'],
        //     'posted_by_id' => $prof['user_id']
        //   ]);
        // });
        //
        // dd($user->getModifiedUsersPosts()->merge($mod));
        // dd($user->getModifiedProfilePictures()[0]->profile_picture);

        $authRequestConfirmed = false;
        $userRequestConfirmed = false;

        // dd($user->profilePictures);
        // dd($user->getModifiedUsersPosts());

        // foreach ($user->posts as $post) {
        //   // $reactedPost = (auth()->user())? auth()->user()->reactedPosts->contains($post) : false;
        //   dd($post->usersReacts[0]->pivot->where('react','Wow'));
        // }

        // $postsWithCount = collect($user->posts)->map(function ($post){
        //   $count = $post->usersReacts->count();
        //   return collect($post)->merge([
        //     'react_count' => $count
        //   ]);
        // });
        //
        // dd($postsWithCount);

        if(Auth::check()){
          foreach(auth()->user()->requestsToBeFriend as $friend){
              if($friend->user->id === $user->id){
                  $authRequestConfirmed = (auth()->user())? $friend->pivot->are_friend : false;
              }
          }

          foreach(auth()->user()->profile->peopleWantToBeYourFriend as $friend){
              if($friend->profile->user->id === $user->id){
                  $userRequestConfirmed = (auth()->user())? $friend->pivot->are_friend : false;
              }
          }
        }

        $requestsFromAuth = (auth()->user())? auth()->user()->requestsToBeFriend->contains($user->id) : false;

        $requestsToAuth = (auth()->user())? auth()->user()->profile->peopleWantToBeYourFriend->contains($user->id) : false;

        $monthArray = ['January','February','March',
                        'April','May','June',
                        'July','August','September',
                        'October','November','December'];
        $birthdayMonth = '';

        foreach($monthArray as $key => $month){
            if(explode('-',$user->birthday)[1] == $key+1){
                $birthdayMonth = $month;
            }
        }

        $birthday = $birthdayMonth. ' ' .explode('-',$user->birthday)[2]. ', '.explode('-',$user->birthday)[0];

        // dd($userRequestConfirmed);

        return view('user.show',compact('user','birthday','requestsFromAuth','requestsToAuth','authRequestConfirmed','userRequestConfirmed'));
    }

    public function edit(User $user){

      if(Auth::check()){
        if($user->id == auth()->user()->id){
          return view('user.edit',compact('user'));
        }
        else{
          return redirect()->route('user.index',$user->id);
        }
      }
      else{
        return redirect()->route('user.index',$user->id);
      }


    }

    public function update(User $user){
      $data = request()->validate([
        'first_name' => 'required',
        'last_name' => 'required',
        'bio' => 'max:200',
      ]);

      auth()->user()->update([
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name']
      ]);

      auth()->user()->profile()->update([
        'bio' => $data['bio'],
        'nickname' => request('nickname'),
        'work' => request('work')?? 'None',
        'home_city' => request('home_city')?? 'None',
        'current_city' => request('current_city')?? 'None',
        'relationship' => request('relationship')?? 'None'
      ]);

      return redirect()->route('user.index',$user->id);

    }
}
