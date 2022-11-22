<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::simplePaginate(10);
        $total_users = User::all()->count();
        $loggedId = intval(Auth::id());
        return view('admin.users.index', [
            'users' => $users,
            'total_users' => $total_users,
            'loggedId' => $loggedId
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:200', 'unique:users'],
            'password' => ['required', 'string', 'min:5', 'confirmed'] 
        ]);
        
        $data = $request->only(['name', 'email', 'password']);
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect(route('users.index'));
    
    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        if($user) {
            return view('admin.users.edit', [
                'user' => $user
            ]);
        }
        return redirect(route('users.index'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

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
                        'min' => '5'
                    ])
                ])->withInput();
               }
            }
            // Salvar os dados
            $user->save();
        }
        return redirect(route('users.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isLoggedId = intval(Auth::id());

        if($isLoggedId !== intval($id)) {
            User::find($id)->delete();
        }
        return redirect(route('users.index'));
    }
}
