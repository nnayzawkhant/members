@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Role Details</h1>
        <p><strong>Name:</strong> {{ $role->name }}</p>
        <!-- Add more details here if needed -->
    </div>
@endsection
