<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;

class RoleController extends Controller
{

    public function create()
    {
        return view('role.create');
    }

    public function save(Request $request)
    {
        // Validate the data being sent
        $valid = $request->validate([
            'role' => 'required',
            'permission' => 'required',
        ]);

        // Save the data
        Role::create($valid);

        // Redirect to another page
        return redirect()->route('user.index');
    }
}
