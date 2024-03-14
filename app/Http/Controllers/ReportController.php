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

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userAuth = Auth::user();
        if($userAuth->user_type_id === 1){
            $reports = ServiceReport::with(['machines.machine_model','status'])->get();
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
        //$catalogParts = Part::where('is_active', 1)->get();
        $catalogCodes = Code::where('is_active', 1)->get();
        $catalogUsers = User::where('is_active', 1)->get();
        $catalogShifts = Shift::where('is_active', 1)->get();
        $catalogModule = Module::where('is_active', 1)->get();
        $catalogFailures = Failure::where('is_active', 1)->get();
        $catalogTypes = FailureType::where('is_active', 1)->get();
        $catalogMachines = Machine::where('is_active', 1)->with([
            'machine_model.model_segment',
            'client',
            'client.branches',
            'client.branches.branchManagers',
            'production_line',
            'production_line.machines',
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

        $branch = Branch::with(['city.country', 'client.branches.reports'])->findOrFail($request['branch_id']);
        
        $totalReports = sprintf("%05d", $branch->client->branches->sum(fn($b) => $b->reports->count()) + 1);
        $currentDate = now()->toDateString();
        
        $completeId = collect([
            $branch->city->country->code,
            $totalReports,
            $currentDate,
            str_replace(' ', '-', strtoupper($branch->client->name)),
            str_replace(' ', '-', strtoupper(Machine::findOrFail($request['machines'][0]['machine_id'])->machine_model->model))
        ])->implode('-');
        $request->merge(['complete_id' => $completeId]);
        $report = ServiceReport::create($request->validate([
            'user_id' => ['required'],
            'complete_id' => ['required'],
            'shift_id' => ['required'],
            'pieces' => ['required'],
            'sogd' => ['required'],
            'time_on' => ['required'],
            'travel_time' => ['required'],
            'report_type_id' => ['required'],
            'branch_id' => ['required'],
            'branch_manager_id' => ['required'],
            'reported_error' => ['required'],
            'code_id' => ['required'],
            'actions_taken' => [],
            'reported' => ['required'],
            'arrival' => [],
            'finished' => [],
            'departure' => [],
            'status_id' => ['required'],
            'signature_client_name_1' => [],
            'signature_client_name_2' => [],
            'is_tested' => ['required'],
            'notes' => [],
        ]));

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
        $report = ServiceReport::with([
            'status',
            'machines',
            'machines.production_line',
            'machines.production_line.machines',
            'parts',
            'parts.part',
            'shift',
        ])->findOrFail($id);
        $latestReports = ServiceReport::where('user_id', Auth::user()->id)->with(['machine','machine.data_client','machine.data_client.client'])->latest()->take(5)->get();

        //$catalogParts = Part::where('is_active', 1)->get();
        $catalogParts = [];
        $catalogCodes = Code::where('is_active', 1)->get();
        $catalogUsers = User::where('is_active', 1)->get();
        $catalogShifts = Shift::where('is_active', 1)->get();
        $catalogModule = Module::where('is_active', 1)->get();
        $catalogFailures = Failure::where('is_active', 1)->get();
        $catalogTypes = FailureType::where('is_active', 1)->get();
        $catalogMachines = Machine::where('is_active', 1)->with([
            'machine_model.model_segment',
            'client',
            'client.branches',
            'client.branches.branchManagers',
            'production_line',
            'production_line.machines',
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * PDF Creation.
     */
    public function pdfReport(string $id) {
        $report = ServiceReport::with([
            'status',
            'machines',
            'machines.machine_model',
            'parts','parts.part',
            'shift',
            'user',
            'branch',
            'branch.client',
            'branch.branchManagers',
        ])->findOrFail($id);
        
        foreach($report->machines as &$machine){
            $machine->pivot->module = Module::findOrFail($machine->pivot->module_id);
            $machine->pivot->failure = Failure::findOrFail($machine->pivot->failure_id);
            $machine->pivot->failure_type = FailureType::findOrFail($machine->pivot->failure_type_id);
        }
        $catalogCodes = Code::where('is_active', 1)->get();
        //return response()->json($report);
        $view = count($report->machines) === 1 ? 'reporte' : 'reporte-banxico';
        $pdf = Pdf::loadView($view, ['catalogCodes' => $catalogCodes, 'report' => $report]);

        return $pdf->download($report->complete_id.'.pdf');
    }
}
