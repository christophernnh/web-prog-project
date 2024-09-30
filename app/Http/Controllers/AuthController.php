<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember') ? true : false;

        if (Auth::attempt($credentials, $remember)) {
            if ($remember) {
                $cookieEmail = cookie('email', $request->email, 120);
                $cookiePassword = cookie('password', $request->password, 120);
                $cookieRemember = cookie('rememberme', $remember, 120);
                return redirect()->intended('/dashboard')->withCookies([$cookieEmail, $cookiePassword, $cookieRemember]);
            }
            return redirect()->intended('/dashboard');
        }

        return redirect('/')->withErrors(['email' => 'Invalid credentials'])->withInput();
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
