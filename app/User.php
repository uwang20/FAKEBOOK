<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'birthday' , 'gender', 'custom_gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot(){
      parent::boot();

      static::created(function ($user){
        $user->profile()->create([
          'work' => 'None',
          'home_city' => 'None',
          'current_city' => 'None',
          'bio' => 'None',
          'relationship' => 'None'
        ]);
      });
    }

    public function profile(){
        return $this->hasOne(Profile::class);
    }

    public function posts(){
        return $this->hasMany(Post::class)->orderBy('created_at','DESC');
    }

    public function getName($id){
      $firstName = $this::find($id)->first_name;
      $lastName = $this::find($id)->last_name;
      return $firstName. ' ' .$lastName;
    }

    public function getProfilePic($id){
      return $this::find($id)->profileIcon();
    }

    //GET MODIFIED USER'S POSTS
    public function getModifiedUsersPosts(){
      $posts = collect($this->posts)->map(function ($post){
        $chosenReact = '';
        $count = $post->usersReacts->count();
        $postedBy = $this::find($post->posted_by_id);


        //EACH REACT ON POST COUNT

        //each react count container
        $likeReact = 0;
        $loveReact = 0;
        $careReact = 0;
        $hahaReact = 0;
        $wowReact = 0;
        $sadReact = 0;
        $angryReact = 0;

        //each react user id container
        $reactLikeUserIds = [];
        $reactLoveUserIds = [];
        $reactCareUserIds = [];
        $reactHahaUserIds = [];
        $reactWowUserIds = [];
        $reactSadUserIds = [];
        $reactAngryUserIds = [];

        $allReactors = [];

        $reactorsId = [];

        foreach ($post->usersReacts as $react) {
          array_push($allReactors,[ 'name' => $this->getName($react->pivot->user_id),
                                    'id' => $react->pivot->user_id,
                                    'react' => $react->pivot->react,
                                    'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);

          array_push($reactorsId, $react->pivot->user_id);

          if($react->pivot->react == 'Like'){
              $likeReact++;
              array_push($reactLikeUserIds,[  'name' => $this->getName($react->pivot->user_id),
                                              'id' => $react->pivot->user_id,
                                              'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Love'){
              $loveReact++;
              array_push($reactLoveUserIds,[  'name' => $this->getName($react->pivot->user_id),
                                              'id' => $react->pivot->user_id,
                                              'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Care'){
              $careReact++;
              array_push($reactCareUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Haha'){
              $hahaReact++;
              array_push($reactHahaUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Wow'){
              $wowReact++;
              array_push($reactWowUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Sad'){
              $sadReact++;
              array_push($reactSadUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Angry'){
              $angryReact++;
              array_push($reactAngryUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
        }
        //END----

        $reactsCount = [
          ['react' => 'like', 'user_id' => $reactLikeUserIds, 'count' => $likeReact],
          ['react' => 'love', 'user_id' => $reactLoveUserIds, 'count' => $loveReact],
          ['react' => 'care', 'user_id' => $reactCareUserIds, 'count' => $careReact],
          ['react' => 'haha', 'user_id' => $reactHahaUserIds, 'count' => $hahaReact],
          ['react' => 'wow', 'user_id' => $reactWowUserIds, 'count' => $wowReact],
          ['react' => 'sad', 'user_id' => $reactSadUserIds, 'count' => $sadReact],
          ['react' => 'angry', 'user_id' => $reactAngryUserIds, 'count' => $angryReact]
        ];



        //each reacts count
        // $likeCount = $post->usersLikes->count();

        // $eachReactCount = [
        //   ['like' => $post->usersLikes()],
        //   ['love' => $post->usersLoves()],
        //   ['care' => $post->usersCares()],
        //   ['haha' => $post->usersHahas()],
        //   ['wow' => $post->usersWows()],
        //   ['sad' => $post->usersSads()],
        //   ['angry' => $post->usersAngries()]
        // ];

        foreach ($post->usersReacts as $react) {
          if(Auth::check()){
            if($react->id == auth()->user()->id){
              $chosenReact = $react->pivot->react;
            }
          }
          else{
            $chosenReact = '';
          }
        }

        $sortedReactsCount = collect($reactsCount)->sortByDesc('count')->values()->all();


        $majorityReacts = collect($sortedReactsCount)->where('count','>',0)->pluck('react')->all();

        $modifiedComments = collect($post->comments)->map(function ($comment){
          $commentBy = User::find($comment->comment_by)->first_name. ' ' .User::find($comment->comment_by)->last_name;

          return collect($comment)->merge([
            'name' => $commentBy,
            'avatar_url' => $this->profileIcon()
          ]);
        });


        // $reactorsId = collect($sortedReactsCount)->map(function ($react){
        //   return collect($react->user_id)->pluck('id')->all();
        // });


        return collect($post)->merge([
            'images' => collect($post->images),
            'react_counts' => $count,
            'posted_by' => $postedBy->first_name. ' ' .$postedBy->last_name,
            'reacted' => Auth::check()? collect($post->usersReacts)->contains('id',auth()->user()->id) : false,
            'chosen_react' => $chosenReact,
            'each_react_count' => $sortedReactsCount,
            'all_reactors' => $allReactors,
            'majority_reacts' => $majorityReacts,
            'comments' => $modifiedComments,
            'show_comments' => false
        ]);
      });

      return $posts;
    }
    //END----------------------

    //GET MODIFIED USER'S PROFILEPictures
    // public function getModifiedUsersProfilePictures(){
    //   $profilePictures = collect($this->profilePictures)->map(function ($post){
    //     $chosenReact = '';
    //     $count = $post->usersReacts->count();
    //     $postedBy = $this::find($post->posted_by_id);
    //
    //
    //     //EACH REACT ON POST COUNT
    //
    //     //each react count container
    //     $likeReact = 0;
    //     $loveReact = 0;
    //     $careReact = 0;
    //     $hahaReact = 0;
    //     $wowReact = 0;
    //     $sadReact = 0;
    //     $angryReact = 0;
    //
    //     //each react user id container
    //     $reactLikeUserIds = [];
    //     $reactLoveUserIds = [];
    //     $reactCareUserIds = [];
    //     $reactHahaUserIds = [];
    //     $reactWowUserIds = [];
    //     $reactSadUserIds = [];
    //     $reactAngryUserIds = [];
    //
    //     $allReactors = [];
    //
    //     $reactorsId = [];
    //
    //     foreach ($post->usersReacts as $react) {
    //       array_push($allReactors,[ 'name' => $this->getName($react->pivot->user_id),
    //                                 'id' => $react->pivot->user_id,
    //                                 'react' => $react->pivot->react,
    //                                 'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //
    //       array_push($reactorsId, $react->pivot->user_id);
    //
    //       if($react->pivot->react == 'Like'){
    //           $likeReact++;
    //           array_push($reactLikeUserIds,[  'name' => $this->getName($react->pivot->user_id),
    //                                           'id' => $react->pivot->user_id,
    //                                           'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //       }
    //       else if($react->pivot->react == 'Love'){
    //           $loveReact++;
    //           array_push($reactLoveUserIds,[  'name' => $this->getName($react->pivot->user_id),
    //                                           'id' => $react->pivot->user_id,
    //                                           'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //       }
    //       else if($react->pivot->react == 'Care'){
    //           $careReact++;
    //           array_push($reactCareUserIds,['name' => $this->getName($react->pivot->user_id),
    //                                         'id' => $react->pivot->user_id,
    //                                         'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //       }
    //       else if($react->pivot->react == 'Haha'){
    //           $hahaReact++;
    //           array_push($reactHahaUserIds,['name' => $this->getName($react->pivot->user_id),
    //                                         'id' => $react->pivot->user_id,
    //                                         'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //       }
    //       else if($react->pivot->react == 'Wow'){
    //           $wowReact++;
    //           array_push($reactWowUserIds,['name' => $this->getName($react->pivot->user_id),
    //                                         'id' => $react->pivot->user_id,
    //                                         'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //       }
    //       else if($react->pivot->react == 'Sad'){
    //           $sadReact++;
    //           array_push($reactSadUserIds,['name' => $this->getName($react->pivot->user_id),
    //                                         'id' => $react->pivot->user_id,
    //                                         'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //       }
    //       else if($react->pivot->react == 'Angry'){
    //           $angryReact++;
    //           array_push($reactAngryUserIds,['name' => $this->getName($react->pivot->user_id),
    //                                         'id' => $react->pivot->user_id,
    //                                         'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
    //       }
    //     }
    //     //END----
    //
    //     $reactsCount = [
    //       ['react' => 'like', 'user_id' => $reactLikeUserIds, 'count' => $likeReact],
    //       ['react' => 'love', 'user_id' => $reactLoveUserIds, 'count' => $loveReact],
    //       ['react' => 'care', 'user_id' => $reactCareUserIds, 'count' => $careReact],
    //       ['react' => 'haha', 'user_id' => $reactHahaUserIds, 'count' => $hahaReact],
    //       ['react' => 'wow', 'user_id' => $reactWowUserIds, 'count' => $wowReact],
    //       ['react' => 'sad', 'user_id' => $reactSadUserIds, 'count' => $sadReact],
    //       ['react' => 'angry', 'user_id' => $reactAngryUserIds, 'count' => $angryReact]
    //     ];
    //
    //
    //
    //     //each reacts count
    //     // $likeCount = $post->usersLikes->count();
    //
    //     // $eachReactCount = [
    //     //   ['like' => $post->usersLikes()],
    //     //   ['love' => $post->usersLoves()],
    //     //   ['care' => $post->usersCares()],
    //     //   ['haha' => $post->usersHahas()],
    //     //   ['wow' => $post->usersWows()],
    //     //   ['sad' => $post->usersSads()],
    //     //   ['angry' => $post->usersAngries()]
    //     // ];
    //
    //     foreach ($post->usersReacts as $react) {
    //       if($react->id == auth()->user()->id){
    //         $chosenReact = $react->pivot->react;
    //       }
    //     }
    //
    //     $sortedReactsCount = collect($reactsCount)->sortByDesc('count')->values()->all();
    //
    //
    //     $majorityReacts = collect($sortedReactsCount)->where('count','>',0)->pluck('react')->all();
    //
    //
    //     // $reactorsId = collect($sortedReactsCount)->map(function ($react){
    //     //   return collect($react->user_id)->pluck('id')->all();
    //     // });
    //
    //
    //     $authFriendsWhoReacted = auth()->user()->confirmedFriends->pluck('user_id')->all();
    //
    //
    //     return collect($post)->merge([
    //         'images' => collect($post->images),
    //         'react_counts' => $count,
    //         'posted_by' => $postedBy->first_name. ' ' .$postedBy->last_name,
    //         'reacted' => collect($post->usersReacts)->contains('id',auth()->user()->id),
    //         'chosen_react' => $chosenReact,
    //         'each_react_count' => $sortedReactsCount,
    //         'all_reactors' => $allReactors,
    //         'majority_reacts' => $majorityReacts,
    //         'auth_friends_react' => $authFriendsWhoReacted
    //     ]);
    //   });
    //
    //   return $profilePictures;
    // }
    //END----------------------




    public function requestsToBeFriend(){
        return $this->belongsToMany(Profile::class)
                    ->withTimestamps()
                    ->withPivot(['are_friend']);
    }

    public function confirmedFriends(){
        return $this->belongsToMany(Profile::class)
                    ->withTimestamps()
                    ->withPivot(['are_friend'])
                    ->wherePivot('are_friend', true);
    }

    public function pendingRequests(){
        return $this->belongsToMany(Profile::class)
                    ->withTimestamps()
                    ->withPivot(['are_friend'])
                    ->wherePivot('are_friend', false);
    }



    public function profilePictures(){
        return $this->hasMany(ProfilePicture::class)->orderBy('updated_at', 'DESC');
    }
/////////////////////
    public function getModifiedProfilePictures(){
      $profilePictures = collect($this->profilePictures)->map(function ($pic){
        $chosenReact = '';
        $count = $pic->usersReacts->count();
        foreach ($pic->usersReacts as $react) {
          if(Auth::check()){
            if($react->id == auth()->user()->id){
              $chosenReact = $react->pivot->react;
            }
          }
          else{
            $chosenReact = '';
          }
        }

        //EACH REACT ON POST COUNT

        //each react count container
        $likeReact = 0;
        $loveReact = 0;
        $careReact = 0;
        $hahaReact = 0;
        $wowReact = 0;
        $sadReact = 0;
        $angryReact = 0;

        //each react user id container
        $reactLikeUserIds = [];
        $reactLoveUserIds = [];
        $reactCareUserIds = [];
        $reactHahaUserIds = [];
        $reactWowUserIds = [];
        $reactSadUserIds = [];
        $reactAngryUserIds = [];

        $allReactors = [];

        $reactorsId = [];

        foreach ($pic->usersReacts as $react) {
          array_push($allReactors,[ 'name' => $this->getName($react->pivot->user_id),
                                    'id' => $react->pivot->user_id,
                                    'react' => $react->pivot->react,
                                    'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);

          array_push($reactorsId, $react->pivot->user_id);

          if($react->pivot->react == 'Like'){
              $likeReact++;
              array_push($reactLikeUserIds,[  'name' => $this->getName($react->pivot->user_id),
                                              'id' => $react->pivot->user_id,
                                              'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Love'){
              $loveReact++;
              array_push($reactLoveUserIds,[  'name' => $this->getName($react->pivot->user_id),
                                              'id' => $react->pivot->user_id,
                                              'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Care'){
              $careReact++;
              array_push($reactCareUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Haha'){
              $hahaReact++;
              array_push($reactHahaUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Wow'){
              $wowReact++;
              array_push($reactWowUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Sad'){
              $sadReact++;
              array_push($reactSadUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
          else if($react->pivot->react == 'Angry'){
              $angryReact++;
              array_push($reactAngryUserIds,['name' => $this->getName($react->pivot->user_id),
                                            'id' => $react->pivot->user_id,
                                            'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
          }
        }
        //END----
        $reactsCount = [
          ['react' => 'like', 'user_id' => $reactLikeUserIds, 'count' => $likeReact],
          ['react' => 'love', 'user_id' => $reactLoveUserIds, 'count' => $loveReact],
          ['react' => 'care', 'user_id' => $reactCareUserIds, 'count' => $careReact],
          ['react' => 'haha', 'user_id' => $reactHahaUserIds, 'count' => $hahaReact],
          ['react' => 'wow', 'user_id' => $reactWowUserIds, 'count' => $wowReact],
          ['react' => 'sad', 'user_id' => $reactSadUserIds, 'count' => $sadReact],
          ['react' => 'angry', 'user_id' => $reactAngryUserIds, 'count' => $angryReact]
        ];
        $sortedReactsCount = collect($reactsCount)->sortByDesc('count')->values()->all();

        $majorityReacts = collect($sortedReactsCount)->where('count','>',0)->pluck('react')->all();


        return collect($pic)->merge([
          'react_counts' => $count,
          'reacted' => Auth::check()? collect($pic->usersReacts)->contains('id',auth()->user()->id) : false,
          'chosen_react' => $chosenReact,
          'each_react_count' => $sortedReactsCount,
          'all_reactors' => $allReactors,
          'majority_reacts' => $majorityReacts
        ]);
      });

      return $profilePictures;
    }
//////////////////////
    public function hasProfilePicture(){
        return ($this->profilePictures()->count())? $this->getModifiedProfilePictures() : collect([collect(['profile_picture' => 'images/default.jpg',
                                                                                'caption' => '',
                                                                                'created_at' => $this->created_at])]);
    }

    public function profileIcon(){
        return ($this->profilePictures()->count())?  $this->profilePictures->first()->profile_picture : 'images/default.jpg';
    }

    /////////////////////
        public function getModifiedCoverPhotos(){
          $coverPhotos = collect($this->coverPhotos)->map(function ($pic){
            $chosenReact = '';
            $count = $pic->usersReacts->count();
            foreach ($pic->usersReacts as $react) {
              if(Auth::check()){
                if($react->id == auth()->user()->id){
                  $chosenReact = $react->pivot->react;
                }
              }
              else{
                $chosenReact = '';
              }
            }

            //EACH REACT ON POST COUNT

            //each react count container
            $likeReact = 0;
            $loveReact = 0;
            $careReact = 0;
            $hahaReact = 0;
            $wowReact = 0;
            $sadReact = 0;
            $angryReact = 0;

            //each react user id container
            $reactLikeUserIds = [];
            $reactLoveUserIds = [];
            $reactCareUserIds = [];
            $reactHahaUserIds = [];
            $reactWowUserIds = [];
            $reactSadUserIds = [];
            $reactAngryUserIds = [];

            $allReactors = [];

            $reactorsId = [];

            foreach ($pic->usersReacts as $react) {
              array_push($allReactors,[ 'name' => $this->getName($react->pivot->user_id),
                                        'id' => $react->pivot->user_id,
                                        'react' => $react->pivot->react,
                                        'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);

              array_push($reactorsId, $react->pivot->user_id);

              if($react->pivot->react == 'Like'){
                  $likeReact++;
                  array_push($reactLikeUserIds,[  'name' => $this->getName($react->pivot->user_id),
                                                  'id' => $react->pivot->user_id,
                                                  'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
              }
              else if($react->pivot->react == 'Love'){
                  $loveReact++;
                  array_push($reactLoveUserIds,[  'name' => $this->getName($react->pivot->user_id),
                                                  'id' => $react->pivot->user_id,
                                                  'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
              }
              else if($react->pivot->react == 'Care'){
                  $careReact++;
                  array_push($reactCareUserIds,['name' => $this->getName($react->pivot->user_id),
                                                'id' => $react->pivot->user_id,
                                                'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
              }
              else if($react->pivot->react == 'Haha'){
                  $hahaReact++;
                  array_push($reactHahaUserIds,['name' => $this->getName($react->pivot->user_id),
                                                'id' => $react->pivot->user_id,
                                                'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
              }
              else if($react->pivot->react == 'Wow'){
                  $wowReact++;
                  array_push($reactWowUserIds,['name' => $this->getName($react->pivot->user_id),
                                                'id' => $react->pivot->user_id,
                                                'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
              }
              else if($react->pivot->react == 'Sad'){
                  $sadReact++;
                  array_push($reactSadUserIds,['name' => $this->getName($react->pivot->user_id),
                                                'id' => $react->pivot->user_id,
                                                'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
              }
              else if($react->pivot->react == 'Angry'){
                  $angryReact++;
                  array_push($reactAngryUserIds,['name' => $this->getName($react->pivot->user_id),
                                                'id' => $react->pivot->user_id,
                                                'profile_pic' => $this->getProfilePic($react->pivot->user_id) ]);
              }
            }
            //END----
            $reactsCount = [
              ['react' => 'like', 'user_id' => $reactLikeUserIds, 'count' => $likeReact],
              ['react' => 'love', 'user_id' => $reactLoveUserIds, 'count' => $loveReact],
              ['react' => 'care', 'user_id' => $reactCareUserIds, 'count' => $careReact],
              ['react' => 'haha', 'user_id' => $reactHahaUserIds, 'count' => $hahaReact],
              ['react' => 'wow', 'user_id' => $reactWowUserIds, 'count' => $wowReact],
              ['react' => 'sad', 'user_id' => $reactSadUserIds, 'count' => $sadReact],
              ['react' => 'angry', 'user_id' => $reactAngryUserIds, 'count' => $angryReact]
            ];
            $sortedReactsCount = collect($reactsCount)->sortByDesc('count')->values()->all();

            $majorityReacts = collect($sortedReactsCount)->where('count','>',0)->pluck('react')->all();


            return collect($pic)->merge([
              'react_counts' => $count,
              'reacted' => Auth::check()? collect($pic->usersReacts)->contains('id',auth()->user()->id) : false,
              'chosen_react' => $chosenReact,
              'each_react_count' => $sortedReactsCount,
              'all_reactors' => $allReactors,
              'majority_reacts' => $majorityReacts
            ]);
          });

          return $coverPhotos;
        }
    //////////////////////

    public function coverPhotos(){
        return $this->hasMany(CoverPhoto::class)->orderBy('updated_at', 'DESC');
    }

    public function hasCoverPhoto(){
        return ($this->coverPhotos()->count())? $this->getModifiedCoverPhotos() : collect([collect(['photo' => 'images/default.jpg',
                                                                                'caption' => '',
                                                                                'created_at' => $this->created_at])]);
    }

    public function coverIcon(){
        return ($this->coverPhotos()->count())?  $this->coverPhotos->first()->cover_photo : 'images/default.jpg';
    }

    // REACTS
    public function reactedPosts(){
      return $this->belongsToMany(Post::class)
                  ->withTimestamps()
                  ->withPivot(['react']);
    }

    public function reactedProfilePictures(){
      return $this->belongsToMany(ProfilePicture::class)
                  ->withTimestamps()
                  ->withPivot(['react']);
    }

    public function reactedCoverPhotos(){
      return $this->belongsToMany(CoverPhoto::class)
                  ->withTimestamps()
                  ->withPivot(['react']);
    }


}
