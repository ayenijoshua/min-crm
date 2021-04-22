@extends('layouts.company')

@section('content')
<div class="row">
  <div class="col-sm-8 offset-md-2">
    <div class="card">
        <img src="{{$company->logo_path}}" class="card-img-top" height="300" alt="Company-logo">
      <div class="card-body">
        <h5 class="card-title">Employess -- {{$company->employees->count() ?? 0}}</h5>
        <p class="card-text">Number of employees in the system</p>
        <a href="{{route('company-employees')}}" class="btn btn-primary">Go to users</a>
      </div>
    </div>
  </div>
</div>
@endsection