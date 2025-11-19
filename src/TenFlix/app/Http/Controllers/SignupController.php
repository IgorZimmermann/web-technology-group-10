<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function signup(Request $request)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = new User;

        // Combine first and last name
        $fullName = trim($request->input('firstName').' '.$request->input('lastName'));
        $user->name = $fullName;
        $user->email = $request->input('email');
        $rawpwd = $request->input('password');
        $user->password = Hash::make($rawpwd);
        $user->is_admin = false;

        $user->save();

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}
