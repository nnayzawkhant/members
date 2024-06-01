@extends('layouts.app')

@section('content')
<div class="container">
    <h1>users</h1>
    @can('create users')
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create user</a>
    @endcan
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">user Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>

                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>


                            <form   action="{{route('users.destroy', $user->id)}}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
