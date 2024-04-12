<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @return View
     *  */
    public function showLogin()
    {
        return view('conduit.login');
    }

    /**
     * @param App\Http\Requests\LoginRequest $request
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $userId = Auth::user()->id;

            return redirect()->route('ownArticles', ['user_id' => $userId]);
        }

        return back()->withErrors([
            'login_error' => 'email or password is invalid',
        ]);
    }

    /**
     * @return View
     *  */
    public function showRegister()
    {
        return view('conduit.register');
    }

    /**
     * @param App\Http\Requests\RegisterRequest $request
     */
    public function register(RegisterRequest $request)
    {
        dd($request->all());
    }
}