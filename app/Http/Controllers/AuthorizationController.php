<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthorizationController extends Controller
{
    public function registration(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }

        if ($request->isMethod('post')) {
            $request['login'] = strtolower($request['login']);
            $validated = $request->validate([
                'login' => 'unique:users|required|between:5,30|regex:/^[0-9a-zA-Z-_]{5,30}$/',
                'password' => 'required|between:10,30|regex:/(?=.*[0-9])(?=.*[!@#$%^&*_])(?=.*[a-z])(?=.*[A-Z])^[0-9a-zA-Z!@#$%^&*_]{10,30}$/',
            ]);
            $user = new User();
            $user->login = $validated['login'];
            $user->password = Hash::make($validated['password']);
            $user->save();
            Auth::login($user);
            return redirect()->route('profile');
        }

        return view('registration');
    }

    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('profile');
        }
        if ($request->isMethod('post')) {
            $request['login'] = strtolower($request['login']);
            $validated = $request->validate([
                'login' => 'required|between:5,30',
                'password' => 'required|between:10,30',
            ]);
            if (Auth::attempt($validated)) {
                $request->session()->regenerate();
                return redirect()->route('profile');
            }
            return redirect()->route('sign_in')->with('error', 'Invalid login or password');
        }
        return view('login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
