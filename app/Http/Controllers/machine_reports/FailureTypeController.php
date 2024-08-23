<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use App\Models\machine_reports\FailureType;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FailureTypeController extends Controller
{
    //Solution
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solutions = FailureType::all();
        return Inertia::render('admin/reports/solutions/index',[
            'solutions' => $solutions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/reports/solutions/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        FailureType::create($request->validate([
            'name' => ['required', 'max:255', 'unique:failure_types'],
        ]));

        return to_route('solutions.index');
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
        $solution = FailureType::findOrFail($id);
        return Inertia::render('admin/reports/solutions/edit',[
            'solution' => $solution
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $solution = FailureType::findOrFail($id);

        $validatedData = $request->validate([
            'name' => ['required', 'max:255', 'unique:failure_types,name,'.$solution->id],
            'is_active' => ['required'],
        ]);

        if($request->input("requested_translation")){
            $validatedData["updated_translation"] = false;
        }
        
        $solution->update($validatedData);

        return to_route('solutions.edit', ['solution' => $solution->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
