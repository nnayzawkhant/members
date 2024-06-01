@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Role</h1>
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
            </div>
            <div class="form-group">
                <label for="permissions">Permissions (comma-separated):</label>
                @foreach($permissions as $permission)
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @if(in_array($permission->id, $role->permissions->pluck('id')->toArray())) checked @endif> {{ $permission->name }}<br>
                @endforeach

            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
