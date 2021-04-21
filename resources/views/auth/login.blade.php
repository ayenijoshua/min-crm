@extends('layouts.auth')

@section('content')
    <!-- Main Content -->
    <login-component base-link-name="Company" base-link="{{route('company.login')}}" panel-title='User Login' post-action={{route('user.auth')}}/>
@endsection