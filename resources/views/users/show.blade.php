
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>user Details</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text">Email: {{ $user->email }}</p>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Back to users</a>
            </div>
        </div>
    </div>
@endsection
