<?php

namespace App\Http\Controllers\machine_reports;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\machine_reports\Branch;
use App\Models\machine_reports\Code;
use App\Models\User;
use App\Models\machine_reports\Status;
use App\Models\machine_reports\Machine;
use App\Models\machine_reports\ServiceReport;
use App\Models\machine_reports\ServiceReportMachine;
use App\Models\machine_reports\ServiceReportMachineDetail;
use App\Models\machine_reports\Shift;
use App\Models\machine_reports\Module;
use App\Models\machine_reports\Failure;
use App\Models\machine_reports\FailureType;
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
            $reports = ServiceReport::where('is_active', true)->with(['machines.machine_model','status', 'user'])->get();
        }else{
            $reports = ServiceReport::where('user_id', $userAuth->id)->where('is_active', true)->with(['machines.machine_model','status', 'user'])->get();
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
            'is_tested' => [],
            'notes' => [],
        ]);
        try{
            DB::beginTransaction();
            
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
            
            foreach($request->all()['machines'] as $machine) {
                $serviceReportMachine = ServiceReportMachine::create([
                    "service_report_id" => $report->id,
                    "machine_id" => $machine['machine_id'],
                    "transport_time_1" => $machine["transport_time_1"],
                    "transport_time_2" => $machine["transport_time_2"],
                    "transport_1" => $machine["transport_1"] ?? 0,
                    "transport_2" => $machine["transport_2"] ?? 0,
                    "transport_3" => $machine["transport_3"] ?? 0,
                    "dt" => $machine["dt"],
                    "signature_client_name" => $machine["signature_client_name"] ?? null,
                ]);
                
                $details = [];
                foreach($machine['machine_details'] as $detail) {
                    if(!empty($detail["module_id"]) || !empty($detail["failure_id"]) || !empty($detail["failure_type_id"]) || !empty($detail["dt"])){
                        $details[] = [
                            'service_report_machine_id' => $serviceReportMachine->id,
                            'module_id' => $detail["module_id"],
                            'failure_id' => $detail["failure_id"],
                            'failure_type_id' => $detail["failure_type_id"],
                            'dt' => $detail["dt"],
                        ];
                    }
                }
                $serviceReportMachine->details()->createMany($details);
            }
            $partsArray = $request->all()['service_parts'];

            $dataParts = [];
            foreach($partsArray as $part) {
                $dataParts[] = ["part_id" => $part["id"], "quantity" => empty($part["quantity"]) ? 0 : $part["quantity"]];
            }
            $report->parts()->createMany($dataParts);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return;
        }
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
            'machineDetails',
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

        $validatedData = $request->validate([
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
            'is_tested' => [],
            'notes' => [],
        ]);

        try {
            DB::beginTransaction();
            $report->update($validatedData);

            $machines = $request->input('machines', []);
            $machineDetails = [];
            foreach ($machines as $machine) {
                $pivotData = [
                    'transport_time_1' => $machine['transport_time_1'],
                    'transport_time_2' => $machine['transport_time_2'],
                    'transport_1' => $machine['transport_1'] ?? 0,
                    'transport_2' => $machine['transport_2'] ?? 0,
                    'transport_3' => $machine['transport_3'] ?? 0,
                    'dt' => $machine['dt'],
                    'signature_client_name' => $machine['signature_client_name'] ?? null,
                ];

                $report->machines()->sync([$machine['machine_id'] => $pivotData], false);
                $report->machines()->updateExistingPivot($machine['machine_id'], $pivotData);

                $updatedMachine = $report->machines()->where('machine_id', $machine['machine_id'])->first();
                $service_report_machine_id = $updatedMachine->pivot->id;

                foreach($machine['machine_details'] as $detail) {
                    if(!empty($detail['module_id']) || !empty($detail['failure_id']) || !empty($detail['failure_type_id']) || !empty($detail["dt"])){
                        $machineDetails[] = [
                            'id' => $detail['id'] ?? null,
                            'service_report_machine_id' => $detail['service_report_machine_id'] ?? $service_report_machine_id,
                            'module_id' => $detail['module_id'],
                            'failure_id' => $detail['failure_id'],
                            'failure_type_id' => $detail['failure_type_id'],
                            'dt' => $detail['dt'],
                        ];
                    }
                }
            }
            
            $incomingIds = array_column(array_filter($machineDetails, function($detail) {
                return isset($detail['id']);
            }), 'id');

            $existingDetails = $report->machineDetails()->pluck('service_report_machine_details.id')->toArray();
            $idsToDelete = array_diff($existingDetails, $incomingIds);
            
            if (!empty($idsToDelete)) {
                $report->machineDetails()->whereIn('service_report_machine_details.id', $idsToDelete)->delete();
            }
            
            $report->machineDetails()->upsert($machineDetails, ['id'], ['module_id', 'failure_id', 'failure_type_id', 'dt']);
            
            $partsArray = $request->all()['service_parts'];

            foreach($partsArray as $part) {
                $report->parts()->updateOrCreate(
                    ['part_id' => $part['id']],
                    ['quantity' => empty($part['quantity']) ? 0 : $part['quantity']]
                );
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return;
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
    public function pdfReport(string $id,string $lang = 'en') {
        $defaultLocale = app()->getLocale();
        try {
            $lang = substr($lang, 0, 2);
            $report = ServiceReport::with([
                'status',
                'machines' => function($query){
                    $query->orderBy('position', 'asc');
                },
                'machines.machine_model',
                'machineDetails',
                'machineDetails.module',
                'machineDetails.failure',
                'machineDetails.failureType',
                'parts','parts.part',
                'shift',
                'user',
                'branch',
                'branch.client',
                'branch.branchManagers',
            ])->findOrFail($id);

            if (!$report->closed) {
                abort(403, 'Report is not closed');
                return;
            }
            
            $catalogCodes = Code::where('is_active', 1)->get();
            
            $view = count($report->machines) === 1 ? 'reporte' : 'reporte-banxico';
            $lang = $view === 'reporte-banxico' ? 'es' : $lang;
            $lang = view()->exists("{$view}-{$lang}") ? $lang : 'en';
            
            app()->setLocale($lang);
            
            $pdf = Pdf::loadView("{$view}-{$lang}", compact('catalogCodes', 'report'));

            return $pdf->download("{$report->complete_id}.pdf");
        }finally {
            app()->setLocale($defaultLocale);
        }
    }
}
