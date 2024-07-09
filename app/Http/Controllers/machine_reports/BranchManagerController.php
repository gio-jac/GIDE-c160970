<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\machine_reports\Branch;
use Inertia\Inertia;

class BranchManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //$branch = Branch::with(['branchManagers'])->findOrFail($id);

        //foreach ($branch->branchManagers as $key => &$value) {
        //    $value['edit_mode'] = false;
        //}

        return Inertia::render('admin/machines/clients/contacts/edit',[
            'branch' => fn () => Branch::with(['branchManagers'])->findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $branch = Branch::with(['branchManagers'])->findOrFail($id);

        $validatedData = $request->validate([
            '*.id' => [],
            '*.name' => ['required', 'max:255'],
            '*.email' => ['required', 'email', 'max:255'],
            '*.phone' => ['required', 'max:255'],
            '*.is_active' => ['required', 'boolean'],
        ]);

        foreach ($validatedData as $key => &$value) {
            $value['branch_id'] = $branch->id;
        }

        $branch->branchManagers()->upsert($validatedData, ['id'], ['name','email','phone','branch_id','is_active']);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
