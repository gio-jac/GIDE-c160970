<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTitles;
use App\Models\UserTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['country'])->get();
        return Inertia::render('admin/users/index',[
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catalogUserTypes = UserTypes::where('is_active', 1)->get();
        $catalogUserTitles = UserTitles::where('is_active', 1)->get();
        return Inertia::render('admin/users/new',[
            'catalogUserTypes' => $catalogUserTypes,
            'catalogUserTitles' => $catalogUserTitles
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge(['is_active' => 1]);

        $request->merge(['password' => Hash::make($request->input('password'))]);

        User::create($request->validate([
            'emp' => ['required', 'max:10','unique:users'],
            'email' => ['required','email', 'max:255','unique:users'],
            'password' => ['required', 'max:255'],
            'nombre' => ['required', 'max:255'],
            'apellido_paterno' => ['required', 'max:255'],
            'apellido_materno' => ['required', 'max:255'],
            'telefono' => ['max:255'],
            'user_type_id' => ['required','exists:user_types,id'],
            'user_title_id' => ['required','exists:user_titles,id'],
            'is_active' => ['required'],
        ]));

        return to_route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $catalogUserTypes = UserTypes::where('is_active', 1)->get();
        $catalogUserTitles = UserTitles::where('is_active', 1)->get();
        return Inertia::render('admin/users/edit',[
            'catalogUserTypes' => $catalogUserTypes,
            'catalogUserTitles' => $catalogUserTitles,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->validate([
            'emp' => ['required', 'max:10','unique:users,emp,'.$id],
            'email' => ['required','email', 'max:255','unique:users,email,'.$id],
            'nombre' => ['required', 'max:255'],
            'apellido_paterno' => ['required', 'max:255'],
            'apellido_materno' => ['required', 'max:255'],
            'telefono' => ['max:255'],
            'user_type_id' => ['required','exists:user_types,id'],
            'user_title_id' => ['required','exists:user_titles,id'],
            'is_active' => ['required'],
        ]));

        return to_route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::findOrFail($id)->update([
            'is_active' => false,
        ]);
        
        return to_route('users.index');
    }
}
