<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', 'FacebookController@mainDomain');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users', 'UserController@index')->name('users.index');

Route::get('/user/{user}', 'ProfileController@index')->name('user.index');
Route::get('/user/{user}/edit', 'ProfileController@edit')->name('user.edit');
Route::patch('/user/{user}/', 'ProfileController@update')->name('user.update');

Route::get('/user/{user}/friends', 'FriendListController@index')->name('friends.index');
// AJAX CALL
Route::get('/users/{user}/posts', 'UserController@showPosts')->name('post.show');



Route::post('/post/{user}', 'PostController@create')->name('post.create');

Route::post('/post-image/{user}', 'ImageController@store')->name('post-image.store');

Route::get('/posted-by/{user}', 'PostController@getPostedBy')->name('post.getpostedby');
//AJAX REQUEST FOR POST REACR
//POST
Route::post('/post/react/{post}', 'PostController@reactPost');
Route::delete('/post/unreact/{post}', 'PostController@unreactPost');
Route::get('/post/react/count/{post}','PostController@getReactsCount');

Route::post('/user/profile/react/{profilePicture}', 'PostController@reactProfile');
Route::delete('/user/profile/unreact/{profilePicture}', 'PostController@unreactProfile');

Route::post('user/cover/react/{coverPhoto}', 'PostController@reactCover');
Route::delete('user/cover/unreact/{coverPhoto}', 'PostController@unreactCover');
//PROFILE PICTURE
Route::post('/profile/react/{profilePicture}', 'ProfilePictureController@reactPost');
Route::delete('/profile/unreact/{profilePicture}', 'ProfilePictureController@unreactPost');
//post
Route::post('/users/{user}/post/react/{post}','ProfilePictureController@react');
Route::delete('/users/{user}/post/unreact/{post}','ProfilePictureController@unreact');
//cover
Route::post('/cover/react/{coverPhoto}', 'ProfilePictureController@reactCover');
Route::delete('/cover/unreact/{coverPhoto}', 'ProfilePictureController@unreactCover');



// REQUESTING PHASE
Route::post('/add/{user}', 'AddFriendController@store')->name('add.store');
Route::delete('/delete/{user}', 'AddFriendController@destroy')->name('add.destroy');

// CONFIRMING PHASE
Route::patch('/confirm/{user}', 'AddFriendController@confirm')->name('add.confirm');

//PROFILE PICTURE ROUTES
Route::get('/user/{user}/profile-picture', 'ProfilePictureController@show')->name('profilepic.show');
Route::get('/user/{user}/profile-picture/create', 'ProfilePictureController@create')->name('profilepic.create')->middleware('auth');
Route::post('/user/{user}/profile-picture', 'ProfilePictureController@store')->name('profilepic.store');


            //--AJAX PART
Route::patch('/user/{user}/profile-picture/{profile}', 'ProfilePictureController@update')->name('profilepic.update');
Route::get('/user/{user}/profile', 'ProfilePictureController@ajaxShow')->name('profilepic.ajaxShow');
Route::get('/user/{user}/avatar', 'ProfilePictureController@ajaxAvatar')->name('profilepic.ajaxShowAvatar');
Route::get('/mod/{user}',function (User $user){
  dd($user->getModifiedProfilePictures());
});




//COVER PHOTOS RouteServiceProvider
Route::get('/user/{user}/cover-photo', 'ProfilePictureController@show')->name('coverpic.show');
Route::get('/user/{user}/cover-photo/create', 'ProfilePictureController@createCover')->name('coverpic.create')->middleware('auth');
Route::post('/user/{user}/cover-photo', 'ProfilePictureController@storeCover')->name('coverpic.store');
            //--AJAX PART
Route::patch('/user/{user}/cover-photo/{cover}', 'ProfilePictureController@updateCover')->name('coverpic.update');
Route::get('/user/{user}/cover', 'ProfilePictureController@ajaxShowCover')->name('coverpic.ajaxShow');
Route::get('/user/{user}/cover-avatar', 'ProfilePictureController@ajaxCoverAvatar')->name('coverpic.ajaxShowAvatar');


//POST PHOTOS ROUTES
Route::get('/users/{user}/posts/{post}', 'ProfilePictureController@show')->name('posts.index');

Route::get('/users/{user}/post/{post}', 'ProfilePictureController@ajaxShowPost')->name('posts.ajaxShow');

//COMMENT
Route::post('/post/{post}/comment', 'CommentController@postComment')->name('comment.postComment');
