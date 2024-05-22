<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Imports\PartsImport;
use Maatwebsite\Excel\Facades\Excel;
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
        $part = Part::create($request->validate([
            'num_part' => ['required', 'max:255', 'unique:parts'],
            'descripcion' => ['required', 'max:255'],
            'is_active' => ['required'],
        ]));

        return to_route('parts.edit', ['part' => $part->id]);
    }

    /**
     * Store a newly created resource in storage coming from an excel file.
     */
    public function storeExcel(Request $request)
    {
        Excel::import(new PartsImport, request()->file('your_file'));
        /*Part::create($request->validate([
            'num_part' => ['required', 'max:255', 'unique:parts'],
            'descripcion' => ['required', 'max:255'],
            'is_active' => ['required'],
        ]));*/

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
        $part = Part::findOrFail($id);
        return Inertia::render('admin/parts/edit',[
            'part' => $part
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $part = Part::findOrFail($id);

        $part->update($request->validate([
            'num_part' => ['required', 'max:255', 'unique:parts,num_part,'.$id],
            'descripcion' => ['required', 'max:255'],
            'is_active' => ['required'],
        ]));

        return to_route('parts.edit', ['part' => $part->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Part::findOrFail($id)->update([
            'is_active' => false,
        ]);
        
        return to_route('parts.index');
    }

    public function autocomplete(Request $request)
    {
        $search = $request->input('query');

        $results = Part::query()
            ->where('is_active', true)
            ->where(function ($query) use ($search) {
                $query->where('num_part', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%");
            })
            ->get();

        return response()->json($results);
    }
}
