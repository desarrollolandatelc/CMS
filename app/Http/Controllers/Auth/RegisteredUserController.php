<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Clients\Models\Client;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register/Create');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'role' => 'required|exists:roles,name',
            'status' => 'required|boolean',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'password' => Hash::make($request->email),
        ]);

        // Asignamos el role de usuario asignado por el administrador
        $user->assignRole($request->role);

        // Si el usuario tiene un cliente asociado, le asignamos el usuario
        if ($request->client) {
            $client = Client::find($request->client['id']);
            $client->user()->associate($user);
            $client->save();
        }

        event(new Registered($user));

        return redirect(route('register', absolute: false));
    }

    public function edit(User $user): Response
    {
        $user->load('roles', 'client');
        $user->role = $user->roles->first()?->name;
        return Inertia::render('Auth/Register/Edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'role' => 'required|exists:roles,name',
            'status' => 'required|boolean',
        ]);

        $user->update($request->all());

        // Asignamos el role de usuario asignado por el administrador
        $user->syncRoles($request->role);

        // Si el usuario tiene un cliente asociado, le asignamos el usuario
        if ($request->client) {
            $client = Client::find($request->client['id']);
            $client->user()->associate($user);
            $client->save();
        }


        return redirect()->route('users.edit', $user->id);
    }
}
