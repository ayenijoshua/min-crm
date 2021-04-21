@extends('layouts.employee')

@section('content')
<div class="row">
  <div class="col-sm-6">
    <div class="card">
        <img src="{{$user->company->logo_path}}" class="card-img-top" alt="Company-logo">
      <div class="card-body">
        <h5 class="card-title">Company -- {{$user->company->name}}</h5>
        <p class="card-text">Your Company</p>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
        <div class="card-header">
            <h3>Update Profile</h3>
        </div>
      <div class="card-body">
        <edit-employee-component user-id="{{$user->id}}" post-action="{{route('employee.update',['id'=>$user->id])}}" panel-title="Edit employee"/>
        <a href="{{route('admin.users')}}" class="btn btn-primary">Go to users</a>
      </div>
    </div>
  </div>

</div>
@endsection