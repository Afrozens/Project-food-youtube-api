<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    use PasswordValidationRules;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::when($request->get('search'), function ($q, $search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('nickname', 'like', "%$search%");
        })->when($request->get('type'), function ($q, $type) {
            if ($type == 'user') {
                $q->doesntHave('roles');
            } else {
                $q->role($type);
            }
        })->where('id', '!=', $request->user()->id)->paginate(20);

        return inertia('Admin/User', [
            'users' => $users,
            'search' => $request->get('search'),
            'type' => $request->get('type'),
        ]);
    }

    public function create()
    {
        return inertia('Admin/UserCreate');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'nickname' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'nickname' => $input['nickname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $message = 'Usuario Agregado';
        return redirect()->route('admin.users.index')->with([
            'state' => $message
        ]);
    }

    public function edit(User $user)
    {
        return inertia('Admin/UserEdit', [
            'user' => $user
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'nickname' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ]
        ])->validate();

        $user->forceFill([
            'name' => $input['name'],
            'nickname' => $input['nickname'],
            'email' => $input['email'],
        ])->save();

        $message = 'Usuario Editado';
        return back()->with([
            'state' => $message
        ]);
    }

    public function to_admin(User $user)
    {
        if ($user->hasRole('admin')) {
            $message = 'El usuario se ha quitado de administradores.';
            $user->removeRole('admin');
        } else {
            $message = 'El usuario se ha agregado a administradores.';
            $user->assignRole('admin');
        }

        return back()->with([
            'state' => $message
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->img_url)
            Storage::delete($user->img_url, 'users');
        Comment::where('user_id', $user->id)->delete();
        $message = "El usuario ha sido eliminado.";
        return back()->with([
            'state' => $message
        ]);
    }
}
