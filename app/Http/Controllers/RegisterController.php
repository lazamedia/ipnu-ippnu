<?php

namespace App\Http\Controllers;

use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|min:3|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|exists:roles,name'
        ]);
    
        $agent = new Agent();
        $device = $agent->platform() . ' ' . $agent->version($agent->platform()) . ', ' . $agent->browser() . ' ' . $agent->version($agent->browser());
        $ipAddress = $request->ip();
    
        $user = new User($validatedData);
        $user->password = Hash::make($request->password);
        // $user->created_by = Auth::id();
        $user->save();
    
        $user->syncRoles($request->role);
    
        return redirect('/dashboard/user')->with('success', 'User created successfully.');
    }
}
