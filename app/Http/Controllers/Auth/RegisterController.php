<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:50',
            'company_name' => 'nullable|string|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'role' => 'customer',
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Send Welcome Email to User
        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\UserWelcomeMail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed sending User Welcome email: ' . $e->getMessage());
        }

        // Send Alert Email to Admin (sales@petchemparts.com)
        try {
            \Illuminate\Support\Facades\Mail::to('sales@petchemparts.com')->send(new \App\Mail\NewUserRegistrationAdminMail($user));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed sending New User Admin Alert email: ' . $e->getMessage());
        }

        return redirect()->route('home')->with('toast_success', 'Registration successful! Welcome to Petchemparts, ' . $user->name);
    }
}
