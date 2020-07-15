<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;
use App\ProfilePicture;
use App\CoverPhoto;

class ProfilePictureController extends Controller
{
   public function show(User $user,Post $post){
       // dd($post);
       $path = request()->path();
       $postId = $post->id;
       return view('profilepicture.show', compact('user','path','postId'));
   }



   public function create(User $user){
     if($user->id != auth()->user()->id){
       return redirect()->route('users.index',$user->id);
     }
     $path = request()->path();
     return view('profilepicture.create',compact('user','path'));
   }

   public function store(User $user){

     $imagePath = request()->image->store('images','public');
     auth()->user()->profilePictures()->create([
       'profile_picture' => $imagePath,
       'caption' => request()->caption
     ]);

     return response()->json($user->profilePictures);
   }



   public function createCover(User $user){
     if($user->id != auth()->user()->id){
       return redirect()->route('users.index',$user->id);
     }
     $path = request()->path();
     return view('profilepicture.create',compact('user','path'));
   }

   public function storeCover(User $user){

     $imagePath = request()->image->store('images','public');
     auth()->user()->coverPhotos()->create([
       'cover_photo' => $imagePath,
       'caption' => request()->caption
     ]);

     return response()->json($user->coverPhotos);
   }




   public function update(User $user, ProfilePicture $profile){

      $inc = $profile->changes + 1;

      $profile->update([
         'changes' => $inc
      ]);

      return response()->json($user->hasProfilePicture());
   }

   public function updateCover(User $user, CoverPhoto $cover){

      $inc = $cover->changes + 1;

      $cover->update([
         'changes' => $inc
      ]);

      return response()->json($user->hasCoverPhoto());
   }

   // AJAX\PART

   public function ajaxShow(User $user){
       return response()->json($user->hasProfilePicture());
   }

   public function ajaxAvatar(User $user){
      return response()->json($user->profileIcon());
   }


   public function ajaxShowCover(User $user){
       return response()->json($user->hasCoverPhoto());
   }

   public function ajaxCoverAvatar(User $user){
      return response()->json($user->coverIcon());
   }

   public function ajaxShowPost(User $user, Post $post){
      $postId = $post->id;
      $modifiedPost = $user->getModifiedUsersPosts()->where('id',$postId);
      $postImage = collect($modifiedPost[0]);
      return response()->json($postImage);
   }


   //Reacct
   public function react(User $user, Post $post){
     if(auth()->user()->reactedPosts->contains($post)){
       auth()->user()->reactedPosts()->detach($post);
     }
     auth()->user()->reactedPosts()->save($post,['react' => request('react')]);
     $postId = $post->id;
     $modifiedPost = $user->getModifiedUsersPosts()->where('id',$postId);
     $postImage = collect($modifiedPost[0]);
     return response()->json($postImage);
   }
   public function unreact(User $user, Post $post){
     auth()->user()->reactedPosts()->detach($post);
     $postId = $post->id;
     $modifiedPost = $user->getModifiedUsersPosts()->where('id',$postId);
     $postImage = collect($modifiedPost[0]);
     return response()->json($postImage);
   }
//PROFILE
   public function reactPost(ProfilePicture $profilePicture){
     if(auth()->user()->reactedProfilePictures->contains($profilePicture)){
       auth()->user()->reactedProfilePictures()->detach($profilePicture);
     }
     auth()->user()->reactedProfilePictures()->save($profilePicture,['react' => request('react')]);
     return $profilePicture->user->getModifiedProfilePictures();
   }

   public function unreactPost(ProfilePicture $profilePicture){
     auth()->user()->reactedProfilePictures()->detach($profilePicture);
     return $profilePicture->user->getModifiedProfilePictures();
   }
//COVER
   public function reactCover(CoverPhoto $coverPhoto){
     if(auth()->user()->reactedCoverPhotos->contains($coverPhoto)){
       auth()->user()->reactedCoverPhotos()->detach($coverPhoto);
     }
     auth()->user()->reactedCoverPhotos()->save($coverPhoto,['react' => request('react')]);
     return $coverPhoto->user->getModifiedCoverPhotos();
   }

   public function unreactCover(CoverPhoto $coverPhoto){
     auth()->user()->reactedCoverPhotos()->detach($coverPhoto);
     return $coverPhoto->user->getModifiedCoverPhotos();
   }


}
