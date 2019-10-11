@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <nav aria-label="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">
                    @can('manage', App\User::class)
                        <a href="{{route('users.index')}}">Users</a>
                    @endcan
                    @cannot('manage', App\User::class)
                        <span>Users</span>
                    @endcannot
                </li>
                <li class="breadcrumb-item"><a href="{{route('users.show', $user)}}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">User Configuration</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}" id="password_form">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input class="form-control @error('title') is-invalid @enderror" name="password" type="password" placeholder="Password" id="password" aria-describedby="passwordHelp">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input class="form-control @error('title') is-invalid @enderror" name="password_confirmation" type="password" placeholder="Confirm password" id="confirm_password" aria-describedby="passwordHelp">
                            <small id="nameHelp" class="form-text text-muted">New password must be confirmed.</small>
                            <br>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <br>
                                <br>
                                <br>
                            @endif
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                @can('manage', App\User::class)
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}" id="admin_form">
                        @csrf
                        @method('PATCH')
                        <div class="form-group form-check">
                            <input type="hidden" name="is_admin" value="0"/>
                            <input class="form-check-input @error('title') is-invalid @enderror" 
                                type="checkbox"
                                id="is_admin"
                                name="is_admin"
                                value="1"
                                onchange="document.getElementById('admin_form').submit()"
                                @if($user->is_admin) checked @endif
                                aria-describedby="is_adminHelp" />
                            <label for="is_admin" class="form-check-label">Is an Admin.</label>
                            <small id="is_adminHelp" class="form-text text-muted">Whether or not the user is an admin</small>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <br>
                                <br>
                                <br>
                            @endif
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
