@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit User</h3>
        </div>
        <div class="card-body">
        <edit-user-component user-id="{{$id}}" panel-title="Edit User" post-action={{route('admin.update-user',['id'=>$id])}}>
        </div>
    </div>
    
@endsection