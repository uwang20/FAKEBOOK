<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class FriendListController extends Controller
{
    public function index(User $user){
        // $confirmedFriendArray = [];
        // $confirmedFriendsCollection = collect($user->confirmedFriends);
        // $grantedFriendRequestsCollection = collect($user->profile->confirmedFriends);

        // $friendList = $confirmedFriendsCollection->merge($grantedFriendRequestsCollection);


        // foreach($confirmedFriendsCollection as $confirmedFriend){
        //     array_push($confirmedFriendArray, $confirmedFriend->pivot->profile_id);
        // }

        // foreach($grantedFriendRequestsCollection as $confirmedFriend){
        //     array_push($confirmedFriendArray, $confirmedFriend->pivot->user_id);
        // }
        // dd($user->id);
        $friendId = $user->id;
        $authId = auth()->user()->id;

        $friendRequestsId = auth()->user()->profile->friendRequests()->pluck('users.id');

        $confirmedFriendsOne =  $user->confirmedFriends()->pluck('profiles.user_id');
        $confirmedFriendsTwo =  $user->profile->confirmedFriends()->pluck('users.id');
        $friendListsId = $confirmedFriendsOne->merge($confirmedFriendsTwo);   //user friend

        $authConfirmedFriendsOne = auth()->user()->confirmedFriends()->pluck('profiles.user_id');
        $authConfirmedFriendsTwo = auth()->user()->profile->confirmedFriends()->pluck('users.id');
        $authFriendListsId = $authConfirmedFriendsOne->merge($authConfirmedFriendsTwo);   //auth user friend

        $mutualFriends = [];

        foreach($friendListsId as $userFriend){
            foreach($authFriendListsId as $authFriend){
                if($userFriend == $authFriend){
                    array_push($mutualFriends, $authFriend);
                }
            }
        }

        $mutualFriends = collect($mutualFriends);

        $friends = User::whereIn('id', $friendListsId)->get();
        $friendRequests = User::whereIn('id', $friendRequestsId)->get();

            //FRIEND REQUEST'S MUTUAL FRIENDS TO AUTH
            $friendRequestsWithMutual = collect($friendRequests)->map(function ($friendRequest){
                $authConfirmedFriendsOne = auth()->user()->confirmedFriends()->pluck('profiles.user_id');
                $authConfirmedFriendsTwo = auth()->user()->profile->confirmedFriends()->pluck('users.id');
                $authFriendListsIds = $authConfirmedFriendsOne->merge($authConfirmedFriendsTwo);

                $friendRequestConfirmedFriendsOne = $friendRequest->confirmedFriends()->pluck('profiles.user_id');
                $friendRequestConfirmedFriendsTwo =  $friendRequest->profile->confirmedFriends()->pluck('users.id');
                $friendRequestConfirmedFriendsIds = $friendRequestConfirmedFriendsOne->merge($friendRequestConfirmedFriendsTwo);
                $profilePic = $friendRequest->profileIcon();

                $mutualFriends = [];

                foreach($friendRequestConfirmedFriendsIds as $friendRequestConfirmedFriendsId){
                    foreach($authFriendListsIds as $authFriendListsId){
                        if($friendRequestConfirmedFriendsId == $authFriendListsId){
                            array_push($mutualFriends, $authFriendListsId);
                        }
                    }
                }

                return collect($friendRequest)->merge([
                    'mutual' => collect($mutualFriends),
                    'profile_pic' => $profilePic
                ]);
            });
            // dd($friendRequestsWithMutual->count());
            //END LOGIC

            //AUTH FRIEND'S FRIENDS MUTUAL FRIENDS TO AUTH
            $authFriendsFriendsWithMutual = collect($friends)->map(function ($friend){
                $authConfirmedFriendsOne = auth()->user()->confirmedFriends()->pluck('profiles.user_id');
                $authConfirmedFriendsTwo = auth()->user()->profile->confirmedFriends()->pluck('users.id');
                $authFriendListsIds = $authConfirmedFriendsOne->merge($authConfirmedFriendsTwo);

                $friendRequestConfirmedFriendsOne = $friend->confirmedFriends()->pluck('profiles.user_id');
                $friendRequestConfirmedFriendsTwo =  $friend->profile->confirmedFriends()->pluck('users.id');
                $friendRequestConfirmedFriendsIds = $friendRequestConfirmedFriendsOne->merge($friendRequestConfirmedFriendsTwo);
                $profilePic = $friend->profileIcon();

                $mutualFriends = [];

                foreach($friendRequestConfirmedFriendsIds as $friendRequestConfirmedFriendsId){
                    foreach($authFriendListsIds as $authFriendListsId){
                        if($friendRequestConfirmedFriendsId == $authFriendListsId){
                            array_push($mutualFriends, $authFriendListsId);
                        }
                    }
                }

                return collect($friend)->merge([
                    'mutual' => collect($mutualFriends),
                    'profile_pic' => $profilePic
                ]);
            });
            // dd($authFriendsFriendsWithMutual);
            //END LOGIC

        return view('friend.index',compact('friends','authFriendsFriendsWithMutual','friendId','authId','friendRequestsWithMutual'));

    }
}
