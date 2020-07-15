@extends('layouts.app')

@section('content')
<a href="{{route('user.index',$user->id)}}" class="exit-modal">X</a>
<profile-picture  user-id="{{$user->id}}"
                  @auth
                  auth-id="{{Auth::user()->id}}"
                  @else
                  auth-id="{{null}}"
                  @endauth
                  owner="{{$user->first_name. ' ' .$user->last_name}}"
                  request-path="{{$path}}"
                  user-post-id="{{$postId}}"
                  :not-auth="@auth {{0}} @else {{1}} @endauth">
@endsection
