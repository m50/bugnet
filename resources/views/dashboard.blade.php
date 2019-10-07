@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <nav aria-label="breadcrumbs">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Home</li>
            </ol>
            </nav>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
