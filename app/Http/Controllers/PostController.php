<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\ProfilePicture;
use App\CoverPhoto;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Post $post)
    {
        dd(request()->path());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $data = request()->validate([
            'body' => '',
            'posted_by' => '',
            'posted_by_id' => ''
        ]);

        $post = $user->posts()->create($data);

        return response()->json($post);
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
    public function show($id)
    {
        //
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

    //
    protected function getAllPost($post){
      $modProfile = collect($post->user->getModifiedProfilePictures())->map(function ($prof){
        return collect($prof)->merge([
          'images' => [['image' => $prof['profile_picture']]],
          'body' => $prof['caption'],
          'posted_by_id' => $prof['user_id'],
          'post_type' => 'profile',
          'pronoun' => User::find($prof['user_id'])->gender == 'male'? 'his' : 'her'
        ]);
      });

      $modCover = collect($post->user->getModifiedCoverPhotos())->map(function ($prof){
        return collect($prof)->merge([
          'images' => [['image' => $prof['cover_photo']]],
          'body' => $prof['caption'],
          'posted_by_id' => $prof['user_id'],
          'post_type' => 'cover',
          'pronoun' => User::find($prof['user_id'])->gender == 'male'? 'his' : 'her'
        ]);
      });

      $modPost = collect($post->user->getModifiedUsersPosts())->map(function ($post){
        return collect($post)->merge([
          'post_type' => 'post',
          'pronoun' => User::find($post['user_id'])->gender == 'male'? 'his' : 'her'
        ]);
      });


      $postProfile = $modPost->merge($modProfile);
      $allPosts = $postProfile ->merge($modCover);
      $allPostsSorted = $allPosts->sortByDesc('updated_at')->values()->all();
      return $allPostsSorted;
      // $modProfile = collect($post->user->getModifiedProfilePictures())->map(function ($prof){
      //   return collect($prof)->merge([
      //     'images' => [['image' => $prof['profile_picture']]],
      //     'body' => $prof['caption'],
      //     'posted_by_id' => $prof['user_id'],
      //     'post_type' => 'profile'
      //   ]);
      // });
      //
      // $modPost = collect($post->user->getModifiedUsersPosts())->map(function ($post){
      //   return collect($post)->merge([
      //     'post_type' => 'post'
      //   ]);
      // });
      //
      // $allPosts = $modPost->merge($modProfile);
      // $allPostsSorted = $allPosts->sortByDesc('updated_at')->values()->all();
      // return $allPostsSorted;
    }

    public function getPostedBy(User $user){
      return response()->json($user->first_name. ' ' .$user->last_name);
    }
//POST
    public function reactPost(Post $post){
      if(auth()->user()->reactedPosts->contains($post)){
        auth()->user()->reactedPosts()->detach($post);
      }
      auth()->user()->reactedPosts()->save($post,['react' => request('react')]);

      return $this->getAllPost($post);
    }

    public function unreactPost(Post $post){
      auth()->user()->reactedPosts()->detach($post);
      return $this->getAllPost($post);
    }
//Profile
    public function reactProfile(ProfilePicture $profilePicture){
      if(auth()->user()->reactedProfilePictures->contains($profilePicture)){
        auth()->user()->reactedProfilePictures()->detach($profilePicture);
      }
      auth()->user()->reactedProfilePictures()->save($profilePicture,['react' => request('react')]);

      return $this->getAllPost($profilePicture);
    }

    public function unreactProfile(ProfilePicture $profilePicture){
      auth()->user()->reactedProfilePictures()->detach($profilePicture);
      return $this->getAllPost($profilePicture);
    }
//COVER
    public function reactCover(CoverPhoto $coverPhoto){
      if(auth()->user()->reactedCoverPhotos->contains($coverPhoto)){
        auth()->user()->reactedCoverPhotos()->detach($coverPhoto);
      }
      auth()->user()->reactedCoverPhotos()->save($coverPhoto,['react' => request('react')]);

      return $this->getAllPost($coverPhoto);
    }

    public function unreactCover(CoverPhoto $coverPhoto){
      auth()->user()->reactedCoverPhotos()->detach($coverPhoto);
      return $this->getAllPost($coverPhoto);
    }

}
