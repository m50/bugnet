@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <nav aria-label="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('projects.index')}}">Projects</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $project->name }}</li>
            </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">{{ $project->name }}</div>

                <div class="card-body">
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
