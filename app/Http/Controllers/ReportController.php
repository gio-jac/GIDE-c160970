<?php

namespace App\Http\Controllers;

use App\Models\Part;
use App\Models\Code;
use App\Models\User;
use App\Models\Status;
use App\Models\Machine;
use App\Models\ServiceReport;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAuth = Auth::user();
        if($userAuth->user_type_id === 1){
            $reports = ServiceReport::with(['machine.machine_model','status'])->get();
        }else{
            $reports = ServiceReport::where('user_id', $userAuth->id)->with(['machine.machine_model','status'])->get();
        }
        
        return Inertia::render('admin/reports/index', [
            'reports' => $reports
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $catalogParts = Part::where('is_active', 1)->get();
        $catalogCodes = Code::where('is_active', 1)->get();
        $catalogUsers = User::where('is_active', 1)->get();
        $catalogMachines = Machine::where('is_active', 1)->with(['machine_model.model_segment','data_client', 'data_client.client'])->get();
        $catalogStatus = Status::where('is_active', 1)->get();

        return Inertia::render('admin/reports/new',[
            'catalogParts' => $catalogParts,
            'catalogCodes' => $catalogCodes,
            'catalogUsers' => $catalogUsers,
            'catalogStatus' => $catalogStatus,
            'catalogMachines' => $catalogMachines,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userAuth = Auth::user();
        if($userAuth->user_type_id === 2){
            $request->merge(['user_id' => $userAuth->id]);
        }
        $report = ServiceReport::create($request->validate([
            'user_id' => ['required'],
            'machine_id' => ['required'],
            'transport' => ['required'],
            'pieces' => ['required'],
            'sogd' => ['required'],
            'time_on' => ['required'],
            'travel_time' => ['required'],
            'report_type_id' => ['required'],
            'reported_error' => ['required'],
            'fault_symptom' => ['required'],
            'code_id' => ['required'],
            'actions_taken' => [],
            'reported' => ['required'],
            'arrival' => [],
            'finished' => [],
            'departure' => [],
            'status_id' => ['required'],
            'is_tested' => ['required'],
            'dt' => [],
            'notes' => [],
        ]));

        $partsArray = $request->all()['service_parts'];

        $dataParts = [];
        foreach($partsArray as $part) {
            $dataParts[] = ["part_id" => $part["id"], "quantity" => empty($part["quantity"]) ? 0 : $part["quantity"]];
        }

        $report->parts()->createMany($dataParts);

        return to_route('reports.index');
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
