<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use App\Models\machine_reports\Module;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuleController extends Controller
{
    //error
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $errors = Module::all();
        return Inertia::render('admin/reports/errors/index',[
            'errors' => $errors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/reports/errors/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Module::create($request->validate([
            'name' => ['required', 'max:255', 'unique:modules'],
        ]));

        return to_route('errors.index');
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
        $error = Module::findOrFail($id);
        return Inertia::render('admin/reports/errors/edit',[
            'error' => $error
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $error = Module::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'max:255', 'unique:modules,name,'.$error->id],
            'is_active' => ['required'],
        ]);

        if($request->input("requested_translation")){
            $validatedData["updated_translation"] = false;
        }
        
        $error->update($validatedData);

        return to_route('errors.edit', ['error' => $error->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
