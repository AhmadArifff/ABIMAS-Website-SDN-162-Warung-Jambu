<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function logout() {
        Auth::logout();
        return redirect('admin/login');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
