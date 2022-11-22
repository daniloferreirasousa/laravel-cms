<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index() {
        if(Auth::check()) {
            return redirect(route('panel.home'));
        }

        return view('admin.login');
    }

    public function authenticate(Request $r) {
        $validator = $r->validate([
            'email' => ['required', 'email', 'max:100'],
            'password' => ['required', 'string', 'min:6', 'max:20'],
        ]);

        $remember = $r->input('remember', false);
        if(Auth::attempt($validator, $remember)) {
            $r->session()->regenerate();
            return redirect(route('panel.home'));
        } 
    
        return back()->withErrors([
            'password' => 'E-mail e/ou senha inválidos',
        ])->onlyInput('email');
        

    }

    public function logout() {
        Auth::logout();
        return redirect(route('panel.login'));
    }
}
