<?php

namespace App\Http\Controllers;

use App\Models\machine_reports\Code;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $codes = Code::all();
        return Inertia::render('admin/reports/codes/index',[
            'codes' => $codes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/reports/codes/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Code::create($request->validate([
            'code' => ['required', 'max:255', 'unique:codes'],
            'description' => ['required', 'max:255'],
            'is_active' => ['required'],
        ]));

        return to_route('codes.index');
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
        Code::findOrFail($id)->update([
            'is_active' => false,
        ]);
        
        return to_route('codes.index');
    }
}
