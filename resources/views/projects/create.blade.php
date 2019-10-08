@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <nav aria-label="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('projects.index')}}">Projects</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Create Project</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('projects.store') }}">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">Name: <span style="color: red; font-size: .9em;">*</span></label>
                            <input value="{{ old('name') }}" required class="form-control @error('title') is-invalid @enderror" name="name" type="text" placeholder="Project Name" id="name" aria-describedby="nameHelp">
                            <small id="nameHelp" class="form-text text-muted"></small>
                            <br>
                            @error('name')
                                <span class="alert alert-danger">{{ $message }}</span> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description: </label>
                            <textarea rows="2" class="form-control @error('title') is-invalid @enderror" name="description" type="text" placeholder="Project Description" id="description" aria-describedby="descriptionHelp">{{ old('description') }}</textarea>
                            <small id="descriptionHelp" class="form-text text-muted">Short description of your project.</small>
                            <br>
                            @error('description')
                                <span class="alert alert-danger">{{ $message }}</span> 
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="url">URL:</label>
                            <input value="{{ old('url') }}" class="form-control @error('title') is-invalid @enderror" name="url" type="text" placeholder="Project URL" id="url" aria-describedby="urlHelp">
                            <small id="urlHelp" class="form-text text-muted">Optional link to your project.</small>
                            <br>
                            @error('url')
                                <span class="alert alert-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tags">Tags: </label>
                            <input value="{{ old('tags') }}" class="form-control @error('title') is-invalid @enderror" name="tags" type="text" placeholder="Project Tags" id="tags" aria-describedby="tagsHelp">
                            <small id="tagsHelp" class="form-text text-muted">Comma separate the tags for the project.</small>
                            <br>
                            @error('tags')
                                <span class="alert alert-danger">{{ $message }}</span> 
                            @enderror
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
