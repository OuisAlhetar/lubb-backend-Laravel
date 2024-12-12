<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $verification_code = rand(100000, 999999);  // Generate the verification code

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => ['required', 'string', 'exists:roles,name'], // Validate that role exists in the roles table
            'verification_code' => $verification_code,  // Store the verification code
        ]);

        event(new Registered($user));

        // Assign the role dynamically from the request
        $role = $request->input('role');  // Get the role from the request
        $user->assignRole($role);

        Auth::login($user);

        // Send verification email or WhatsApp message
        Mail::to($user->email)->send(new \App\Mail\VerifyEmail($verification_code));

        return response()->noContent();
    }
}