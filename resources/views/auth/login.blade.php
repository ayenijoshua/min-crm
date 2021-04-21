@extends('layouts.auth')

@section('content')
    <!-- Main Content -->
    <login-component panel-title='User Login' post-action={{route('user.auth')}}/>
@endsection