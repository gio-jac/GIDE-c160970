<?php

namespace App\Http\Controllers;

use App\Models\machine_reports\UserTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = UserTypes::all();
        return Inertia::render('admin/users/types/index',[
            'types' => $types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/users/types/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        UserTypes::create($request->validate([
            'tipo' => ['required', 'max:255', 'unique:user_types'],
            'is_active' => ['required'],
        ]));

        return to_route('types.index');
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
        $type = UserTypes::findOrFail($id);
        return Inertia::render('admin/users/types/edit',[
            'type' => $type
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $type = UserTypes::findOrFail($id);
        $type->update($request->validate([
            'tipo' => ['required', 'max:255', 'unique:user_types,tipo,'.$id],
            'is_active' => ['required'],
        ]));

        return to_route('types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        UserTypes::findOrFail($id)->update([
            'is_active' => false,
        ]);
        
        return to_route('types.index');
    }
}
