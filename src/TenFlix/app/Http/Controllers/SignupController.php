<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Hash;

class SignupController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $data = $request->validated();

        $user = new User;

        // Combine first and last name
        $fullName = trim(($data['firstName'] ?? '') . ' ' . ($data['lastName'] ?? ''));
        $user->name = $fullName;
        $user->email = $data['email'];
        $rawpwd = $data['password'];
        $user->password = Hash::make($rawpwd);
        $user->is_admin = false;

        $user->save();

        return redirect('/login')->with('success', 'Registration successful! Please login.');
    }
}
