<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserTitles;
use App\Models\UserTypes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
