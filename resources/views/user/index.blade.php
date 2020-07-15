@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">USERS</div>

                <div class="card-body">
                   <div class="list-group">
                       @foreach($users as $key => $user)
                       <li class="list-group-item">
                        <strong class="mr-2">{{$key + 1}}</strong><a href="/user/{{$user->id}}" class="">{{$user->first_name.' '.$user->last_name}}</a>
                       </li>
                       @endforeach
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
