<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Branch;
use App\Models\Code;
use App\Models\User;
use App\Models\Status;
use App\Models\Machine;
use App\Models\ServiceReport;
use App\Models\Shift;
use App\Models\Module;
use App\Models\Failure;
use App\Models\FailureType;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAuth = Auth::user();
        if($userAuth->user_type_id === 1){
            $reports = ServiceReport::with(['machines.machine_model','status', 'user'])->get();
        }else{
            $reports = ServiceReport::where('user_id', $userAuth->id)->with(['machines.machine_model','status', 'user'])->get();
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
        //$catalogParts = Part::where('is_active', 1)->get();
        $catalogCodes = Code::where('is_active', 1)->get();
        $catalogUsers = User::where('is_active', 1)->get();
        $catalogShifts = Shift::where('is_active', 1)->get();
        $catalogModule = Module::where('is_active', 1)->orderBy('name')->get();
        $catalogFailures = Failure::where('is_active', 1)->orderBy('name')->get();
        $catalogTypes = FailureType::where('is_active', 1)->orderBy('name')->get();
        $catalogMachines = Machine::where('is_active', 1)->with([
            'machine_model.model_segment',
            'client',
            'client.branches',
            'client.branches.branchManagers',
            'production_line',
            'production_line.machines' => function($query){
                $query->orderBy('position', 'asc');
            },
            'production_line.machines.machine_model',
            'production_line.machines.machine_model.model_segment',
        ])->get();
        $catalogStatus = Status::where('is_active', 1)->get();
        
        return Inertia::render('admin/reports/new',[
            'catalogCodes' => $catalogCodes,
            'catalogUsers' => $catalogUsers,
            'catalogStatus' => $catalogStatus,
            'catalogMachines' => $catalogMachines,
            'catalogShifts' => $catalogShifts,
            'catalogModule' => $catalogModule,
            'catalogFailures' => $catalogFailures,
            'catalogTypes' => $catalogTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userAuth = Auth::user();
        $request->merge($userAuth->user_type_id === 2 ? ['user_id' => $userAuth->id] : []);
        $validatedData = $request->validate([
            'user_id' => ['required'],
            'shift_id' => ['required'],
            'machines' => ['required', 'array', 'min:1'],
            'pieces' => [],
            'sogd' => [],
            'time_on' => [],
            'travel_time' => [],
            'report_type_id' => [],
            'branch_id' => ['required'],
            'branch_manager_id' => ['required'],
            'reported_error' => [],
            'code_id' => [],
            'actions_taken' => [],
            'reported' => [],
            'arrival' => [],
            'finished' => [],
            'departure' => [],
            'status_id' => [],
            'signature_client_name_1' => [],
            'signature_client_name_2' => [],
            'is_tested' => [],
            'notes' => [],
        ]);
        $branch = Branch::with(['city.country', 'client.branches.reports'])->findOrFail($request['branch_id']);
        
        $nextId = ServiceReport::max('id') + 1;
        $currentDate = now()->toDateString();

        $completeId = implode('-', [
            $branch->city->country->code,
            $nextId,
            $currentDate,
            str_replace(' ', '-', strtoupper($branch->client->name)),
            str_replace(' ', '-', strtoupper(Machine::findOrFail($request['machines'][0]['machine_id'])->machine_model->model))
        ]);
        $validatedData['complete_id'] = $completeId;
        $report = ServiceReport::create($validatedData);
        //machines: [] as Array<any>,
        foreach($request->all()['machines'] as $machine) {
            $report->machines()->attach($machine["machine_id"],[
                "module_id" => $machine["module_id"],
                "failure_id" => $machine["failure_id"],
                "failure_type_id" => $machine["failure_type_id"],
                "transport_time_1" => $machine["transport_time_1"],
                "transport_time_2" => $machine["transport_time_2"],
                "transport_1" => $machine["transport_1"] ?? 0,
                "transport_2" => $machine["transport_2"] ?? 0,
                "transport_3" => $machine["transport_3"] ?? 0,
                "dt" => $machine["dt"],
            ]);
        }
        //$report->machines()->createMany($dataMachines);

        //service_parts: [],
        $partsArray = $request->all()['service_parts'];

        $dataParts = [];
        foreach($partsArray as $part) {
            $dataParts[] = ["part_id" => $part["id"], "quantity" => empty($part["quantity"]) ? 0 : $part["quantity"]];
        }
        $report->parts()->createMany($dataParts);
            
        
        return to_route('reports.edit', ['report' => $report->id]);
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
        $report = ServiceReport::with([
            'status',
            'machines',
            'machines.production_line',
            'machines.production_line.machines' => function($query){
                $query->orderBy('position', 'asc');
            },
            'parts',
            'parts.part',
            'shift',
        ])->findOrFail($id);
        $latestReports = ServiceReport::where('user_id', Auth::user()->id)->latest()->take(5)->get();

        //$catalogParts = Part::where('is_active', 1)->get();
        $catalogParts = [];
        $catalogCodes = Code::where('is_active', 1)->get();
        $catalogUsers = User::where('is_active', 1)->get();
        $catalogShifts = Shift::where('is_active', 1)->get();
        $catalogModule = Module::where('is_active', 1)->orderBy('name')->get();
        $catalogFailures = Failure::where('is_active', 1)->orderBy('name')->get();
        $catalogTypes = FailureType::where('is_active', 1)->orderBy('name')->get();
        $catalogMachines = Machine::where('is_active', 1)->with([
            'machine_model.model_segment',
            'client',
            'client.branches',
            'client.branches.branchManagers',
            'production_line',
            'production_line.machines' => function($query){
                $query->orderBy('position', 'asc');
            },
            'production_line.machines.machine_model',
            'production_line.machines.machine_model.model_segment',
        ])->get();
        $catalogStatus = Status::where('is_active', 1)->get();
        return Inertia::render('admin/reports/edit',[
            'catalogParts' => $catalogParts,
            'catalogCodes' => $catalogCodes,
            'catalogUsers' => $catalogUsers,
            'catalogStatus' => $catalogStatus,
            'catalogMachines' => $catalogMachines,
            'catalogShifts' => $catalogShifts,
            'catalogModule' => $catalogModule,
            'catalogFailures' => $catalogFailures,
            'catalogTypes' => $catalogTypes,
            'report' => $report,
            'latestReports' => $latestReports,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userAuth = Auth::user();
        $request->merge($userAuth->user_type_id === 2 ? ['user_id' => $userAuth->id] : []);
        $report = ServiceReport::findOrFail($id);
        
        if($report->closed) {
            return;
        }

        $report->update($request->validate([
            'user_id' => ['required'],
            'shift_id' => ['required'],
            'pieces' => [],
            'sogd' => [],
            'time_on' => [],
            'travel_time' => [],
            'report_type_id' => [],
            'branch_id' => ['required'],
            'branch_manager_id' => ['required'],
            'reported_error' => [],
            'code_id' => [],
            'actions_taken' => [],
            'reported' => [],
            'arrival' => [],
            'finished' => [],
            'departure' => [],
            'status_id' => [],
            'signature_client_name_1' => [],
            'signature_client_name_2' => [],
            'is_tested' => [],
            'notes' => [],
        ]));

        $machines = $request->input('machines', []);

        foreach ($machines as $machine) {
            $pivotData = [
                'module_id' => $machine['module_id'],
                'failure_id' => $machine['failure_id'],
                'failure_type_id' => $machine['failure_type_id'],
                'transport_time_1' => $machine['transport_time_1'],
                'transport_time_2' => $machine['transport_time_2'],
                'transport_1' => $machine['transport_1'] ?? 0,
                'transport_2' => $machine['transport_2'] ?? 0,
                'transport_3' => $machine['transport_3'] ?? 0,
                'dt' => $machine['dt'],
            ];

            $report->machines()->sync([$machine['machine_id'] => $pivotData], false);
            $report->machines()->updateExistingPivot($machine['machine_id'], $pivotData);
        }

        $partsArray = $request->all()['service_parts'];

        foreach($partsArray as $part) {
            $report->parts()->updateOrCreate(
                ['part_id' => $part['id']],
                ['quantity' => empty($part['quantity']) ? 0 : $part['quantity']]
            );
        }

        return to_route('reports.edit', ['report' => $report->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Close report.
     */
    public function closeReport(string $id) {
        $report = ServiceReport::when(Auth::user()->user_type_id === 2, function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        if($report->closed) {
            return;
        }

        /*
        Validator::make($report->toArray(), [
            'user_id' => ['required'],
            'shift_id' => ['required'],
            'branch_id' => ['required'],
            'branch_manager_id' => ['required'],
        ])->validate();*/

        $report->closed = true;
        $report->save();

        return to_route('reports.edit', ['report' => $report->id]);
    }

    /**
     * Reopen report.
     */
    public function reOpenReport(string $id) {
        $report = ServiceReport::findOrFail($id);

        if(Auth::user()->user_type_id !== 1){
            return;
        }

        if(!$report->closed) {
            return;
        }

        $report->closed = false;
        $report->save();

        return to_route('reports.edit', ['report' => $report->id]);
    }

    /**
     * PDF Creation.
     */
    public function pdfReport(string $id) {
        $report = ServiceReport::with([
            'status',
            'machines' => function($query){
                $query->orderBy('position', 'asc');
            },
            'machines.machine_model',
            'parts','parts.part',
            'shift',
            'user',
            'branch',
            'branch.client',
            'branch.branchManagers',
        ])->findOrFail($id);

        if(!$report->closed) {
            return;
        }
        
        foreach($report->machines as &$machine){
            $machine->pivot->module = Module::find($machine->pivot->module_id);
            $machine->pivot->failure = Failure::find($machine->pivot->failure_id);
            $machine->pivot->failure_type = FailureType::find($machine->pivot->failure_type_id);
        }
        $catalogCodes = Code::where('is_active', 1)->get();
        //return response()->json($report);
        $view = count($report->machines) === 1 ? 'reporte' : 'reporte-banxico';
        $pdf = Pdf::loadView($view, ['catalogCodes' => $catalogCodes, 'report' => $report]);

        return $pdf->download($report->complete_id.'.pdf');
    }
}
