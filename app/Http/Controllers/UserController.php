<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        // Check if the current user has the 'admin' role
        if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('editor') || auth()->user()->hasRole('viewer')) {
            // If so, retrieve all users from the database
            $users = User::all();
            
            return view('users.index', compact('users'));
        } else {
            // For other roles, redirect the user to the home page or show an error message
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
    }

    public function create()
    {
        // Check if the current user has the 'admin' or 'editor' role
        if (auth()->user()->hasAnyRole(['admin', 'editor'])) {
            // If so, allow them to view the create form
            $roles = Role::all();
            toastr()->closeButton()->timeOut(10000)->addSuccess('Create Successfully');
            return view('users.create', compact('roles'));
            
        } else {
            // For 'viewer' role, redirect the user to the home page or show an error message
            toastr()->closeButton()->timeOut(10000)->addWarning('You do not have permission to access this page.');
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
    }

    public function store(Request $request)
    {
        // Check if the current user has the 'admin' or 'editor' role
        if (auth()->user()->hasAnyRole(['admin', 'editor'])) {
            // If so, continue with the store operation
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|exists:roles,id',
            ]);

            // Create user and assign role
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $user->assignRole(Role::find($request->role));

            toastr()->closeButton()->timeOut(10000)->addSuccess('User Created successfully.');
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } else {
            // For 'viewer' role, prevent them from creating a new user and redirect them back
            toastr()->closeButton()->timeOut(10000)->addWarning('You do not have permission to access this page.');
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
    }

    public function show(User $user)
    {
        // Check if the current user has the 'admin' or 'viewer' role
        if (auth()->user()->hasAnyRole(['admin', 'viewer'])) {
            // If so, allow them to view the user details
            toastr()->closeButton()->timeOut(10000)->addSuccess('User show successfully.');
            return view('users.show', compact('user'));
            
        } else {
            // For 'editor' role, redirect the user to the home page or show an error message
            toastr()->closeButton()->timeOut(10000)->addWarning('You do not have permission to access this page.');
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
    }

    public function edit(User $user)
    {
        // Check if the current user has the 'admin' or 'editor' role
        if (auth()->user()->hasAnyRole(['admin', 'editor'])) {
            // If so, allow them to edit the user details
            $roles = Role::all();
            toastr()->closeButton()->timeOut(10000)->addSuccess('User Edit successfully.');
            return view('users.edit', compact('user', 'roles'));
        } else {
            // For 'viewer' role, redirect the user to the home page or show an error message
            toastr()->closeButton()->timeOut(10000)->addWarning('You do not have permission to access this page.');
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
    }

    public function update(Request $request, User $user)
    {
        // Check if the current user has the 'admin' or 'editor' role
        if (auth()->user()->hasAnyRole(['admin', 'editor'])) {
            // If so, continue with the update operation
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'role' => 'required|exists:roles,id',
            ]);

            // Update user details and role
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            $user->syncRoles(Role::find($request->role));

            toastr()->closeButton()->timeOut(10000)->addSuccess('User Update successfully.');
            return redirect()->route('users.index')->with('success', 'User updated successfully.');
        } else {
            // For 'viewer' role, prevent them from updating the user details and redirect them back
            toastr()->closeButton()->timeOut(10000)->addWarning('You do not have permission to access this page.');
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
    }

    public function destroy(User $user)
    {
        // Check if the current user has the 'admin' role
        if (auth()->user()->hasRole('admin')) {
            // If so, allow them to delete the user
            $user->delete();
            toastr()->closeButton()->timeOut(10000)->addSuccess('User deleted successfully.');
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } else {
            // For
            toastr()->closeButton()->timeOut(10000)->addWarning('You do not have permission to access this page.');
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }
    }
}
