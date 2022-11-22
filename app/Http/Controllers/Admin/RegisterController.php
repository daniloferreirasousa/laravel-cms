<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{

    protected $redirectTo = '/panel';
    
    public function index() {
        if(Auth::check()) {
            return redirect(route('panel.home'));
        }
        return view('admin.register');
    }

    public function register(Request $r) {
        $r->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $data = $r->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        User::create($data);
        return redirect(route('panel.login'));

    }
}
