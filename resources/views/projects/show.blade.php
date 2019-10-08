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
                    <a class="card-link" href="{{ route('projects.edit', $project) }}"><i class="fa fa-edit"></i></a>
                    <a class="card-link" href="{{ route('shared-projects.share-to', $project) }}"><i class="fas fa-share"></i></a>
                    <a class="card-link" style="color: red; float:right;" href="{{ route('projects.destroy', $project) }}" 
                        onclick="event.preventDefault(); document.getElementById('delete-form').submit();">
                        <i class="fas fa-times"></i>
                    </a>
                    <form id="delete-form" method="POST" action="{{ route('projects.destroy', [$project]) }}" style="display: none;">
                        @method('DELETE')
                        @csrf
                    </form>
                    <p class="card-text">{{ $project->description }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">API Token: {{ $project->api_token }}</li>
                    <li class="list-group-item">Tags:
                        @foreach ($project->tags as $tag)
                            <a style="font-size: 1em; color: white" 
                                class="badge badge-pill badge-info" 
                                href="{{ route('projects.index').'?filter='.$tag }}">
                                {{ $tag }}
                            </a>
                        @endforeach
                    </li>
                    <li class="list-group-item">Created: {{ $project->created_at->diffForHumans() }}</li>
                    <li class="list-group-item">Last Updated: {{ $project->updated_at->diffForHumans() }}</li>
                </ul>
                <div class="card-body">
                    URL: <a href="{{ $project->url }}" class="card-link">{{ $project->url }}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row"><br></div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Errors</div>

                <div class="card-body">
                    @foreach ($project->errors as $error)
                        
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
