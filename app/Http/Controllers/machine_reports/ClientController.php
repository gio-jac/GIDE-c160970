<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use App\Models\machine_reports\Client;
use App\Models\machine_reports\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return Inertia::render('admin/machines/clients/index',[
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/machines/clients/new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Client::create($request->validate([
            'name' => ['required', 'max:255', 'unique:clients'],
            'is_active' => ['required'],
        ]));

        return to_route('clients.index');
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
        $client = Client::with(['branches','branches.city','branches.city.country'])->findOrFail($id);

        foreach ($client->branches as $key => &$value) {
            $value['edit_mode'] = false;
        }

        $catalogCountries = Country::with('cities')->get();
        return Inertia::render('admin/machines/clients/edit',[
            'client' => $client,
            'catalogCountries' => $catalogCountries
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $client->update($request->validate([
            'name' => ['required', 'max:255', 'unique:clients'],
            'is_active' => ['required'],
        ]));

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
