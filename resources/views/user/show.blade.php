@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                   <div class="photos">
                        <profile-avatar user-id="{{$user->id}}"
                                        @auth
                                          auth="{{Auth::user()->id}}"
                                        @else
                                          auth="{{null}}"
                                        @endauth
                                        view-profile-url="{{route('profilepic.show',$user->id)}}"
                                        select-profile-url="{{route('profilepic.create',$user->id)}}"
                                        view-cover-url="{{route('coverpic.show',$user->id)}}"
                                        select-cover-url="{{route('coverpic.create',$user->id)}}">
                    </div>

                    <div class="main-details">
                        <div class="left-space"></div>
                        <div class="right-space p-2">
                            <h2>{{$user->first_name. ' ' .$user->last_name}} @if($user->profile->nickname != null)<span class="text-muted">{{'('.$user->profile->nickname.')'}}</span>@endif</h2>
                            @auth
                              @if($user->id != Auth::user()->id)
                              <follow-button
                                  user-id="{{$user->id}}"
                                  requests-from-auth="{{$requestsFromAuth}}"
                                  requests-to-auth="{{$requestsToAuth}}"
                                  user-request-confirmed="{{$userRequestConfirmed}}"
                                  auth-request-confirmed="{{$authRequestConfirmed}}">
                               @endif
                            @else
                            @endauth
                        </div>
                    </div>

                    <div class="container mb-2">
                        <a href="/user/{{$user->id}}/friends/" class="btn btn-outline-info">Friends</a>
                    </div>

                    <div class="profile-feed">
                        <div class="details">
                            <div class="card mb-2">
                                <div class="card-header mb-4 text-center">Bio</div>
                                 <p class="card-text text-center mb-4">
                                    {{$user->profile->bio?? 'none'}}
                                 </p>
                            </div>

                            <div class="card">
                                <div class="card-header details-container">
                                    Details
                              @auth
                                @if($user->id == Auth::user()->id)
                                  <a href="{{route('user.edit',$user->id)}}" class="btn btn-primary" name="button">Edit</a>
                                @endif
                              @endauth
                                </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item font-weight-bold text-muted">Birthday:<span class="ml-2 font-weight-light">{{$birthday}}</span></li>
                                        <li class="list-group-item font-weight-bold text-muted">Work:<span class="ml-2 font-weight-light">{{$user->profile->work}}</span></li>
                                        <li class="list-group-item font-weight-bold text-muted">Current City:<span class="ml-2 font-weight-light">{{$user->profile->current_city}}</span></li>
                                        <li class="list-group-item font-weight-bold text-muted">Home City:<span class="ml-2 font-weight-light">{{$user->profile->home_city}}</span></li>
                                        <li class="list-group-item font-weight-bold text-muted">Relationship:<span class="ml-2 font-weight-light">{{$user->profile->relationship}}</span></li>
                                    </ul>
                            </div>
                        </div>

                        <div class="feed">
                            <example-component :user-id="{{$user}}"
                                              :not-auth="@auth {{0}} @else {{1}} @endauth"
                                              :auth-id="@auth {{Auth::user()->id}} @else {{0}} @endauth"
                                              auth-name="@auth {{Auth::user()->first_name. ' ' .Auth::user()->last_name}} @else {{null}} @endauth"
                                              :user-posts="{{$user->posts}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        // const btnPost = document.querySelector('.post-btn');
        // var postField = document.querySelector('.post-textarea');

    </script>
@endsection
