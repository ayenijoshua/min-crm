@extends('layouts.admin')

@section('content')
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Companies -- {{$companies}}</h5>
        <p class="card-text">Number of companies in the system</p>
        <a href="{{route('admin.companies')}}" class="btn btn-primary">Go to companies</a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Users -- {{$users}}</h5>
        <p class="card-text">Number of users in the system</p>
        <a href="{{route('admin.users')}}" class="btn btn-primary">Go to users</a>
      </div>
    </div>
  </div>
</div>
@endsection