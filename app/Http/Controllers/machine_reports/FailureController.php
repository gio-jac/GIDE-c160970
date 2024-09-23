<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use App\Models\machine_reports\Failure;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FailureController extends Controller
{
    //Cause
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $causes = Failure::all();
        return Inertia::render('admin/reports/causes/index',[
            'causes' => $causes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/reports/causes/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Failure::create($request->validate([
            'name' => ['required', 'max:255', 'unique:failures'],
            'es' => ['nullable', 'max:100', Rule::unique('failures')->whereNull('es')],
            'pt' => ['nullable', 'max:100', Rule::unique('failures')->whereNull('pt')],
        ]));

        return to_route('causes.index');
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
        $cause = Failure::findOrFail($id);
        return Inertia::render('admin/reports/causes/edit',[
            'cause' => $cause
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cause = Failure::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'max:255', 'unique:failures,name,'.$cause->id],
            'es' => ['nullable', 'max:100', Rule::unique('failures')->ignore($cause->id)->whereNull('es')],
            'pt' => ['nullable', 'max:100', Rule::unique('failures')->ignore($cause->id)->whereNull('pt')],
            'is_active' => ['required'],
        ]);

        if($request->input("requested_translation")){
            $validatedData["updated_translation"] = false;
        }
        
        $cause->update($validatedData);

        return to_route('causes.edit', ['cause' => $cause->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
