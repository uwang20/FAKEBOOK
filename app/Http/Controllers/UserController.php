<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = User::all();
        // dd($users);


        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //  $user->load('posts.images');
        // dd($user->posts[1]->images);

        // $requests = (auth()->user())? auth()->user()->friendRequests->contains($user->id) : false;

        dd(auth()->user());

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


        return view('user.show',compact('user','birthday','requests'));
    }



    public function showPosts(User $user){
      $modProfile = collect($user->getModifiedProfilePictures())->map(function ($prof){
        return collect($prof)->merge([
          'images' => [['image' => $prof['profile_picture']]],
          'body' => $prof['caption'],
          'posted_by_id' => $prof['user_id'],
          'post_type' => 'profile',
          'pronoun' => User::find($prof['user_id'])->gender == 'male'? 'his' : 'her'
        ]);
      });

      $modCover = collect($user->getModifiedCoverPhotos())->map(function ($prof){
        return collect($prof)->merge([
          'images' => [['image' => $prof['cover_photo']]],
          'body' => $prof['caption'],
          'posted_by_id' => $prof['user_id'],
          'post_type' => 'cover',
          'pronoun' => User::find($prof['user_id'])->gender == 'male'? 'his' : 'her'
        ]);
      });

      $modPost = collect($user->getModifiedUsersPosts())->map(function ($post){
        return collect($post)->merge([
          'post_type' => 'post',
          'pronoun' => User::find($post['user_id'])->gender == 'male'? 'his' : 'her'
        ]);
      });


      $postProfile = $modPost->merge($modProfile);
      $allPosts = $postProfile ->merge($modCover);
      $allPostsSorted = $allPosts->sortByDesc('updated_at')->values()->all();
      return $allPostsSorted;
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
