@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                   <div class="list-group">
                    <a href="{{url('/users')}}" class="list-group-item">List of Users</a>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
