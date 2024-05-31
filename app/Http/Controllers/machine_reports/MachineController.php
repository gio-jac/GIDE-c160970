<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use App\Models\machine_reports\Machine;
use App\Models\machine_reports\MachineModels;
use App\Models\machine_reports\ProductionLine;
use App\Models\machine_reports\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $machines = Machine::with(["machine_model","machine_model.model_segment","production_line"])->get();
        return Inertia::render('admin/machines/index',[
            'machines' => $machines
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $machineModels = MachineModels::orderBy('model', 'asc')->get();
        $productionLines = ProductionLine::orderBy('name', 'asc')->get();
        $clients = Client::orderBy('name', 'asc')->get();

        return Inertia::render('admin/machines/new',[
            'machineModels' => $machineModels,
            'productionLines' => $productionLines,
            'clients' => $clients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge($request->get('production_line_id') === null ? ['position' => 1, 'only_dt' => false] : []);
        $machine = Machine::create($request->validate([
            'serial' => ['required', 'max:255', 'unique:machines'],
            'machine_model_id' => ['required'],
            'client_id' => ['required'],
            'production_line_id' => [],
            'position' => ['required_if:production_line_id,!=,null','min:1','max:99'],
            'only_dt' => ['required_if:production_line_id,!=,null'],
        ]));

        return to_route('machines.index');
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
        $machine = Machine::findOrFail($id);
        $machineModels = MachineModels::orderBy('model', 'asc')->get();
        $productionLines = ProductionLine::orderBy('name', 'asc')->get();
        $clients = Client::orderBy('name', 'asc')->get();

        return Inertia::render('admin/machines/edit',[
            'machine' => $machine,
            'machineModels' => $machineModels,
            'productionLines' => $productionLines,
            'clients' => $clients
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $machine = Machine::findOrFail($id);

        $machine->update($request->validate([
            'serial' => ['required', 'max:255', 'unique:machines,serial,' . $id],
            'machine_model_id' => ['required'],
            'client_id' => ['required'],
            'production_line_id' => [],
            'position' => ['required_if:production_line_id,!=,null','min:1','max:99'],
            'only_dt' => ['required_if:production_line_id,!=,null'],
            'is_active' => ['required'],
        ]));

        return to_route('machines.edit', ['machine' => $machine->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
