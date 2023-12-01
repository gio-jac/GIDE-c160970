<?php

namespace App\Http\Controllers;

use App\Models\UserTitles;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserTitleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $titles = UserTitles::all();
        return Inertia::render('admin/users/titles/index',[
            'titles' => $titles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/users/titles/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        UserTitles::create($request->validate([
            'titulo' => ['required', 'max:255', 'unique:user_titles'],
            'is_active' => ['required'],
        ]));

        return to_route('titles.index');
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
        $title = UserTitles::findOrFail($id);
        return Inertia::render('admin/users/titles/edit',[
            'title' => $title
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $title = UserTitles::findOrFail($id);
        $title->update($request->validate([
            'titulo' => ['required', 'max:255', 'unique:user_titles,titulo,'.$id],
            'is_active' => ['required'],
        ]));

        return to_route('titles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        UserTitles::findOrFail($id)->update([
            'is_active' => false,
        ]);
        
        return to_route('titles.index');
    }
}
