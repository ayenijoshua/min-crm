@extends('layouts.company')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Employees</h3>
        </div>
        <employees-component company-id={{$id}}/>
    </div>
@endsection