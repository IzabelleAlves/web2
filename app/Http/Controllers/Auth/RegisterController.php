<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' =>  User::ROLE_CLIENTE,
        ]);
    }

    public function edit(User $user)
{
    // só admin pode editar papéis
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Ação não autorizada.');
    }

    return view('users.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Ação não autorizada.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'role' => 'required|in:admin,bibliotecario,cliente',
    ]);

    $user->update($request->only('name', 'email', 'role'));

    return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
}
}
