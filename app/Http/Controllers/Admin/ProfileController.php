<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function index() {
        $loggedId = intval(Auth::id());
        
        $user = User::find($loggedId);

        if($user) {
            return view('admin.profile.index', [
                'user' => $user
            ]);
        }
        return redirect(route('panel.home'));
    }

    public function save(Request $request)
    {
        $loggedId = intval(Auth::id());
        $user = User::find($loggedId);

        if($user) {       
            $data = $request->only(['name', 'email', 'password', 'password_confirmation']);
            
           $request->validate([
                'name' => ['required', 'string', 'max:100'],
                'email' => ['required', 'email', 'max:100']
            ]);
           
            // 1. Alteração do nome
            $user->name = $data['name'];

            // 2. Alteração do e-mail
            if($user->email != $data['email']) {
                $hasEmail = User::where('email', $data['email'])->get();
                if(count($hasEmail) === 0) {
                    $user->email = $data['email'];
                } else {
                    return back()->withErrors([
                        // 'email' => 'O E-mail já está em uso'
                        'email' => __('validation.attributes.email.exists', [
                            'attribute' => $data['email']
                        ]),
                    ])->withInput();
                }
            }
            
            // 3. Alteração da senha
            // 3.1 Verifica se o usuário digitou senha
            if(!empty($data['password'])) {
               // 3.2 Verifica se a confirmação está ok
               if(strlen($data['password']) >= 5) { 
                    if($data['password'] === $data['password_confirmation']) {
                        // 3.3 Altera a senha
                        $user->password = Hash::make($data['password']);
                    } else {
                        return back()->withErrors([
                            'password' => __('validation.different', [
                                'attribute' => 'password',
                                'other' => 'password_confirmation'
                            ]),
                        ])->withInput();
                    }
               } else {
                return back()->withErrors([
                    // 'password' => 'A senha deve ter no mínimo 5 caractéres'
                    'password' => __('validation.min.string', [
                        'attribute' => 'password',
                        'min' => 6
                    ])
                ])->withInput();
               }
            }
            // Salvar os dados
            $user->save();
            return redirect(route('panel.profile'))->with('warning', 'As informações foram alteradas com sucesso.');

        }
        return redirect(route('panel.profile'));
    }
}
