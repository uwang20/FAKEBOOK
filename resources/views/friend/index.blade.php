@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header font-weight-bold">{{$authFriendsFriendsWithMutual->count()}} Friends</div>
                    <ul class="list-group list-group-flush">
                        @foreach($authFriendsFriendsWithMutual as $authFriendsFriendWithMutual)
                        <li class="list-group-item font-weight-bold text-muted">
                          <div class="container row align-items-center">
                            <div style="display: inline-block; border-radius: 50%; background-image: url('/storage/{{$authFriendsFriendWithMutual['profile_pic']}}'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 50px; width: 50px;">
                            </div>
                            <div class="col-md-10">
                              <a href="{{route('users.index',$authFriendsFriendWithMutual['id'])}}" class="text-dark font-weight-light">{{$authFriendsFriendWithMutual['first_name']. ' ' . $authFriendsFriendWithMutual['last_name']}}</a>
                              @if($authFriendsFriendWithMutual['id'] != $authId)
                                  @if($authFriendsFriendWithMutual['mutual']->count())
                                  <div class="text-mute font-weight-lighter"><a href="#" style="color: rgba(0,0,0,0.5); text-decoration: none">{{$authFriendsFriendWithMutual['mutual']->count()}} mutual friends</a></div>
                                  @endif
                              @endif
                            </div>
                          </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @if($friendId == $authId)
                <div class="card mt-4">
                    <div class="card-header font-weight-bold">{{$friendRequestsWithMutual->count()}} Friend Requests</div>
                    <ul class="list-group list-group-flush">
                        @foreach($friendRequestsWithMutual as $friendRequestWithMutual)
                        <li class="list-group-item font-weight-bold text-muted">
                          <div class="container">
                            <div class="row align-items-center">
                              <div style="display: inline-block; border-radius: 50%; background-image: url('/storage/{{$friendRequestWithMutual['profile_pic']}}'); background-position: center; background-size: cover; background-repeat: no-repeat; height: 50px; width: 50px;">
                              </div>
                              <div class="col-md-10">
                                <a href="{{route('users.index',$friendRequestWithMutual['id'])}}" class="text-dark font-weight-light">{{$friendRequestWithMutual['first_name']. ' ' . $friendRequestWithMutual['last_name']}}</a>
                                @if($friendRequestWithMutual['mutual'])
                                <div class="text-mute font-weight-lighter"><a href="#" style="color: rgba(0,0,0,0.5); text-decoration: none">{{$friendRequestWithMutual['mutual']->count()}} mutual friends</a></div>
                                @endif
                              </div>
                            </div>
                          </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
