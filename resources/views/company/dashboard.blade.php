@extends('layouts.company')

@section('content')
<div class="row">
  <div class="col-sm-8 offset-md-2">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Employess -- {{$employees}}</h5>
        <p class="card-text">Number of employees in the system</p>
        <a href="{{route('admin.users')}}" class="btn btn-primary">Go to users</a>
      </div>
    </div>
  </div>
</div>
@endsection