@extends('layouts.auth')

@section('content')
    <!-- Main Content -->
<login-component base-link-name="User" base-link="{{route('login')}}" panel-title='Company Login' post-action={{route('company.auth')}}/>
@endsection