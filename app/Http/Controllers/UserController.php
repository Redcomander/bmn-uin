<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('user_account.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::select(['role', 'id'])->get();
        // dd($roles);
        return view('user_account.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validation rules for the password
        $passwordRules = [
            'required',
            'string',
            'min:6',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
        ];

        // Validation messages for the password rules
        $passwordMessages = [
            'regex' => 'The password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
        ];

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'password' => $passwordRules,
        ], $passwordMessages);

        // Check if the validation fails
        if ($validator->fails()) {
            return redirect('user/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Create the user if validation passes
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        return redirect('user');
    }

    public function show(User $user)
    {
        return view('user_account.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::select(['role', 'id'])->get();
        return view('user_account.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        User::where('id', $id)->update([
            "name" => $request->name,
            "username" => $request->username,
            "role_id" => $request->role_id,
        ]);

        return redirect('user');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect('/user');
    }
}
