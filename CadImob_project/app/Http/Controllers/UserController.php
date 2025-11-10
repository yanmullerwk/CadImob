<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsersRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\RedirectResponse as HttpFoundationRedirectResponse;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;

class UserController extends Controller
{
    public function index(){
        $users = User::paginate(5);
        
        return Inertia::render('Users/UserPage', [
            'users' => $users,
        ]);
    }

    public function create(){
        return Inertia::render('Users/UserCadastroPage');
    }

    public function store(StoreUsersRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'profile' => $request->profile,
            'cpf' => $request->cpf,
            'activate'=>$request->activate,
            'password' => Hash::make($request->password),
        ]);
    }

    public function edit($id): Response
    {
        $user = User::findOrFail($id);

        return Inertia::render('Profile/Edit', [
            'user' => $user
        ]);
    }

    public function update(ProfileUpdateRequest $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
    
        
        $dados = $request->validated();

        
        $user->update($dados);

        return Redirect::route('user.edit', $id);
    }

    public function toggleActivate($id)
    {
        $user = User::findOrFail($id);

        // Alterna entre 'S' e 'N'
        $user->activate = $user->activate === 'S' ? 'N' : 'S';
        $user->save();

        return back()->with('success', 'Status do usuário atualizado.');
    }
}
