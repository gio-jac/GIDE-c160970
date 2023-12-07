<?php

namespace App\Http\Controllers;

use App\Models\Part;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parts = Part::all();
        return Inertia::render('admin/parts/index',[
            'parts' => $parts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/parts/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Part::create($request->validate([
            'num_part' => ['required', 'max:255', 'unique:parts'],
            'descripcion' => ['required', 'max:255'],
            'is_active' => ['required'],
        ]));

        return to_route('parts.index');
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
