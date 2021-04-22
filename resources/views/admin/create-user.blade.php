@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Create User</h3><span class="text-error" style="color: red;">(All fields are required)</span>
        </div>
        <div class="card-body">
            <create-user-component panel-title="Create User" post-action={{route('admin.store-user')}}>
        </div>
    </div>
    
@endsection