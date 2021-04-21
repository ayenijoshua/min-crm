@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Company</h3>
        </div>
        <div class="card-body">
            <edit-company-component company-id="{{$id}}" panel-title="Edit Company" post-action={{route('admin.update-company',['id'=>$id])}}>
        </div>
        
    </div>
    
@endsection