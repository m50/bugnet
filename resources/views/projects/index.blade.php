@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <nav aria-label="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Projects</li>
            </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
    <div class="col">
        <div class="card">
            <div class="card-header">Projects 
                @if(request()->has('filter'))
                    <span style="float: right; font-size: 1em; color: white" class="badge badge-pill badge-info">
                        {{ request()->filter }}
                        &nbsp;&nbsp;
                        <a style="float: right; font-size: 1em; color: white" 
                            href="{{ route('projects.index') }}">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                @endif
            </div>
            <div>
            {{ $projects->links() }}
            <a style="font-size: 2em; float: right; color: blue; margin: 0.25em; margin-right: 2em;"
                href="{{ route('projects.create') }}">
                <i class="fas fa-plus-circle"></i>
            </a>
            </div>
            <table class="table">
                <thead>
                    <th scope="col">Owner</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Last Modified</th>
                    <th scope="col">Options</th>
                </thead>
                <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <td><a href="{{ route('users.show', $project->owner) }}">
                            <img src="{{ $project->owner->gravatar}}" alt="{{ $project->owner->name }}'s avatar'" class="rounded-circle" />
                        </a></td>
                        <td><a href="{{ route('projects.show', [$project]) }}">{{ $project->name }}<a></td>
                        <td>{{ Str::limit($project->description, 48) }}</td>
                        <td>
                            @foreach ($project->tags as $tag)
                                <a style="font-size: 1em; color: white" 
                                    class="badge badge-pill badge-info" 
                                    href="{{ route('projects.index').'?filter='.$tag }}">
                                    {{ $tag }}
                                </a>
                            @endforeach
                        </td>
                        <td>{{ $project->updated_at->diffForHumans() }}</td>
                        <td>
                            <a style="font-size: 1.05em" href="{{ route('projects.edit', [$project]) }}"><i class="fa fa-edit"></i></a>
                            &nbsp;&nbsp;&nbsp;
                            <a style="font-size: 1.05em" href="{{ route('projects.destroy', [$project]) }}"
                                    onclick="event.preventDefault(); document.getElementById('delete-{{ $project->slug }}').submit();">
                                    <i class="fas fa-trash"></i>
                            </a>
                            <form id="delete-{{ $project->slug }}" method="POST" action="{{ route('projects.destroy', [$project]) }}" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td>No projects...</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>
</div>
@endsection
