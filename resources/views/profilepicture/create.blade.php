@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <select-profile user-id="{{$user->id}}" path="{{$path}}">
    </div>
  </div>
</div>
@endsection
