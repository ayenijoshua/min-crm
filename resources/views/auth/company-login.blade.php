@extends('layouts.auth')

@section('content')
    <!-- Main Content -->
<login-component panel-title='Company Login' post-action={{route('company.auth')}}/>
@endsection