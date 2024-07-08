<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use App\Models\machine_reports\Client;
use Illuminate\Http\Request;

class BranchController extends Controller
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $validatedData = $request->validate([
            '*.id' => [],
            '*.address' => ['required', 'max:255'],
            '*.city_id' => ['required'],
            '*.is_active' => ['required'],
        ]);

        foreach ($validatedData as $key => &$value) {
            $value['client_id'] = $client->id;
        }
        
        $client->branches()->upsert($validatedData, ['id'], ['address','city_id','client_id','is_active']);

        return to_route('clients.edit', ['client' => $client->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
