@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Create Company</h3>
        </div>
        <div class="card-body">
            <create-company-component panel-title="Create User" post-action={{route('admin.store-company')}}>
        </div>
    </div>
    
@endsection