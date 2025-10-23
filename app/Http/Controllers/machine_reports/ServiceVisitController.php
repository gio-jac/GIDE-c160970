<?php

namespace App\Http\Controllers\machine_reports;

use App\Models\machine_reports\ServiceReport;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\machine_reports\ServiceVisit;
use App\Models\machine_reports\ServiceReportMachine;
use App\Models\machine_reports\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\machine_reports\Branch;
use App\Models\machine_reports\Module;
use App\Models\machine_reports\Failure;
use App\Models\machine_reports\FailureType;
use App\Models\machine_reports\Code;
use Illuminate\Support\Facades\Cache;
use App\Models\machine_reports\Status;

class ServiceVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $threeMonthsAgo = now()->subMonthsNoOverflow(3);

        $visits = ServiceVisit::query()
            ->where('is_active', true)
            ->where('created_at', '>=', $threeMonthsAgo)
            ->when($user->user_type_id !== 1, fn ($q) => $q->where('user_id', $user->id))
            ->select([
                'id',
                'complete_id',
                'user_id',
                'branch_id',
                'closed as status',
                'created_at',
            ])
            ->with([
                'user:id,nombre,apellido_paterno,apellido_materno',
                'branch:id,city_id',
                'branch.client:id,name',
                'branch.city:id,name,country_id',
            ])
            ->withCount('serviceReports')
            ->latest('created_at')
            ->get()
            ->each(fn ($report) => $report->setAttribute('user_full_name', $report->user->full_name));

        $catalogCountry = Country::query()
            ->where('is_active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $catalogYearReports = ServiceVisit::query()
            ->where('is_active', true)
            ->when($user->user_type_id !== 1, fn ($q) => $q->where('user_id', $user->id))
            ->selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();

        return Inertia::render('admin/reports/index', [
            'reports'             => $visits,
            'catalogCountry'      => $catalogCountry,
            'catalogYearReports'  => $catalogYearReports,
        ]);
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
        $auth = Auth::user();

        $tabs = collect((array) $request->input('tabs', []));

        if ($tabs->count() > 1) {
            $tabs = $tabs->filter(function ($tab) {
                $machines = $tab['machines'] ?? [];
                return is_array($machines) && !empty($machines);
            });
        }

        $tabs = $tabs->map(function ($tab) {
            $machines = $tab['machines'] ?? null;

            if (!is_array($machines) || empty($machines)) {
                return $tab;
            }

            $tab['machines'] = collect($machines)->map(function ($machine) {
                $details = $machine['machine_details'] ?? [];

                if (!is_array($details) || empty($details)) {
                    $machine['machine_details'] = [];
                    return $machine;
                }
                
                $machine['machine_details'] = collect($details)
                    ->filter(function ($d) {
                        return filled($d['module_id'] ?? null)
                            || filled($d['failure_id'] ?? null)
                            || filled($d['failure_type_id'] ?? null)
                            || filled($d['dt'] ?? null);
                    })
                    ->values()
                    ->all();

                return $machine;
            })->values()->all();

            return $tab;
        })->values()->all();

        $payload = ['tabs' => $tabs];

        if ((int) ($auth->user_type_id ?? 0) === 2) {
            $payload['user_id'] = $auth->id;
        }

        $request->merge($payload);

        $validatedData = $request->validate([
            'user_id' => ['bail','required', 'integer', 'exists:users,id'],
            'shift_id' => ['bail','required', 'integer', 'exists:shifts,id'],
            'client_id' => ['bail','required', 'integer', 'exists:clients,id'],
            'branch_id' => ['bail','required', 'integer', 'exists:branches,id'],
            'branch_manager_id' => ['bail','required', 'integer', 'exists:branch_managers,id'],
            'service_date' => ['bail','required', 'date_format:Y-m-d'],
            'service_timezone' => ['bail','required', 'timezone'],
            
            'tabs' => ['bail','required', 'array', 'min:1'],
            'tabs.*.pieces' => ['bail','nullable', 'integer', 'min:0', 'max:999999999999'],
            'tabs.*.sogd' => ['bail','nullable', 'string', 'max:255'],
            'tabs.*.travel_time' => ['bail','nullable', 'integer', 'min:0', 'max:10080'],
            'tabs.*.time_on' => ['bail', 'nullable', 'numeric', 'decimal:0,2', 'gte:0', 'lte:9999999.99'],
            'tabs.*.report_type_id' => ['bail','required', 'integer', 'min:1', 'max:2'],
            'tabs.*.reported_error' => ['bail','nullable', 'string', 'max:255'],
            'tabs.*.code_id' => ['bail','nullable', 'integer', 'exists:codes,id'],
            'tabs.*.actions_taken' => ['bail','nullable', 'string', 'max:255'],
            'tabs.*.reported' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.arrival' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.departure' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.finished' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.status_id' => ['bail','nullable', 'integer', 'exists:statuses,id'],
            'tabs.*.is_tested' => ['bail','nullable', 'boolean'],
            'tabs.*.notes' => ['bail','nullable', 'string', 'max:255'],
            
            'tabs.*.service_parts' => ['bail','present', 'array'],
            'tabs.*.service_parts.*.id' => ['bail','required', 'integer', 'exists:parts,id'],
            'tabs.*.service_parts.*.quantity' => ['bail','required', 'integer', 'min:0', 'max:999999999999'],

            'tabs.*.machines' => ['bail','required','array','min:1'],
            'tabs.*.machines.*.machine_id' => ['bail','required', 'integer', 'exists:machines,id'],
            'tabs.*.machines.*.transport_1' => ['bail','nullable', 'decimal:0,1', 'gte:0', 'lte:9999.9'],
            'tabs.*.machines.*.transport_2' => ['bail','nullable', 'decimal:0,1', 'gte:0', 'lte:9999.9'],
            'tabs.*.machines.*.transport_3' => ['bail','nullable', 'decimal:0,1', 'gte:0', 'lte:9999.9'],
            'tabs.*.machines.*.dt' => ['bail','nullable', 'integer', 'min:0', 'max:999999'],
            'tabs.*.machines.*.signature_client_name' => ['bail','nullable', 'string', 'max:255'],

            'tabs.*.machines.*.machine_details'  => ['bail','present', 'array'],
            'tabs.*.machines.*.machine_details.*.module_id'  => ['bail','nullable', 'integer', 'exists:modules,id'],
            'tabs.*.machines.*.machine_details.*.failure_id'  => ['bail','nullable', 'integer', 'exists:failures,id'],
            'tabs.*.machines.*.machine_details.*.failure_type_id'  => ['bail','nullable', 'integer', 'exists:failure_types,id'],
            'tabs.*.machines.*.machine_details.*.dt' => ['bail','nullable', 'integer', 'min:0', 'max:999999'],
        ]);
        
        DB::beginTransaction();
        try {
            $branch = Branch::with(['city.country', 'client.branches.reports'])->findOrFail($validatedData['branch_id']);

            $nextId = ServiceVisit::max('id') + 1;
            $currentDate = $validatedData['service_date'];

            $completeId = implode('-', [
                $branch->city->country->code,
                $nextId,
                $currentDate,
                str_replace(' ', '-', strtoupper($branch->client->name)),
            ]);

            $validatedData['complete_id'] = $completeId;
            
            $serviceVisit = ServiceVisit::create([
                'complete_id' => $completeId,
                'user_id' => $validatedData['user_id'],
                'shift_id' => $validatedData['shift_id'],
                'client_id' => $validatedData['client_id'],
                'branch_id' => $validatedData['branch_id'],
                'branch_manager_id' => $validatedData['branch_manager_id'],
                'service_date' => $validatedData['service_date'],
                'service_timezone' => $validatedData['service_timezone'],
            ]);

            foreach($validatedData['tabs'] as $index => $tab) {
                $reportAttrs = Arr::only($tab, [
                    'pieces','sogd','time_on','travel_time','report_type_id','reported_error',
                    'code_id','actions_taken','reported','arrival','finished','departure',
                    'status_id','is_tested','notes',
                ]);
                $report = $serviceVisit->serviceReports()->create(array_merge($reportAttrs, [
                    'complete_id' => $completeId . '-' . ($index + 1),
                    'branch_manager_id' => $validatedData['branch_manager_id'],
                    'user_id' => $validatedData['user_id'],
                    'service_date' => $validatedData['service_date'],
                    'service_timezone' => "N/A",
                    'shift_id' => $validatedData['shift_id'],
                    'branch_id' => $validatedData['branch_id'],
                    'is_active' => true,
                ]));

                if(!empty($tab['service_parts'])) {
                    $partRows = [];
                    foreach($tab['service_parts'] as $p) {
                        $partRows[] = [
                            'part_id' => $p['id'],
                            'quantity' => $p['quantity'],
                        ];
                    }
                    if($partRows) {
                        $report->parts()->createMany($partRows);
                    }
                }

                foreach($tab['machines'] as $m) {
                    $pivot = ServiceReportMachine::create(array_merge(
                        Arr::only($m, [
                            'machine_id',
                            'transport_1', 'transport_2', 'transport_3',
                            'dt',
                            'signature_client_name',
                        ]),
                        ['service_report_id' => $report->id],
                    ));

                    $detailRows = [];
                    foreach(($m['machine_details'] ?? []) as $d) {
                        $detailRows[] = Arr::only($d, ['module_id', 'failure_id', 'failure_type_id', 'dt']);
                    }

                    if($detailRows) {
                        $pivot->details()->createMany($detailRows);
                    }
                }
            }

            DB::commit();
            return to_route('service-visit.index');
        }catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceVisit $serviceVisit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceVisit $serviceVisit)
    {
        $serviceVisit = ServiceVisit::withEditGraph()->findOrFail($serviceVisit->id);

        $catalogCodes = Cache::remember('catalog:codes:v1', 3600, fn () =>
            Code::query()
                ->where('is_active', 1)
                ->select('id', 'code', 'description')
                ->orderBy('code')
                ->get()
        );
        $catalogModule = Cache::remember('catalog:modules:v1', 3600, fn () =>
            Module::query()
                ->where('is_active', 1)
                ->select('id', 'name', 'es', 'pt')
                ->orderBy('name')
                ->get()
        );
        $catalogFailures = Cache::remember('catalog:failures:v1', 3600, fn () =>
            Failure::query()
                ->where('is_active', 1)
                ->select('id', 'name', 'es', 'pt')
                ->orderBy('name')
                ->get()
        );
        $catalogTypes = Cache::remember('catalog:failure_types:v1', 3600, fn () =>
            FailureType::query()
                ->where('is_active', 1)
                ->select('id', 'name', 'es', 'pt')
                ->orderBy('name')
                ->get()
        );

        $catalogStatus = Cache::remember('catalog:status:v1', 3600, fn () =>
            Status::query()
                ->where('is_active', 1)
                ->select('id', 'status')
                ->orderBy('status')
                ->get()
        );
        
        return Inertia::render('admin/reports/edit',[
            'catalogCodes' => $catalogCodes,
            'catalogStatus' => $catalogStatus,
            'catalogShifts' => [],
            'catalogModule' => $catalogModule,
            'catalogFailures' => $catalogFailures,
            'catalogTypes' => $catalogTypes,
            'report' => $serviceVisit->toArray(),
            'latestReports' => [],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceVisit $serviceVisit)
    {
        if($serviceVisit->closed) {
            return;
        }

        $auth = Auth::user();

        $tabs = collect((array) $request->input('tabs', []));

        if ($tabs->count() > 1) {
            $tabs = $tabs->filter(function ($tab) {
                $machines = $tab['machines'] ?? [];
                return is_array($machines) && !empty($machines);
            });
        }

        $tabs = $tabs->map(function ($tab) {
            $machines = $tab['machines'] ?? null;

            if (!is_array($machines) || empty($machines)) {
                return $tab;
            }

            $tab['machines'] = collect($machines)->map(function ($machine) {
                $details = $machine['machine_details'] ?? [];

                if (!is_array($details) || empty($details)) {
                    $machine['machine_details'] = [];
                    return $machine;
                }
                
                $machine['machine_details'] = collect($details)
                    ->filter(function ($d) {
                        return filled($d['module_id'] ?? null)
                            || filled($d['failure_id'] ?? null)
                            || filled($d['failure_type_id'] ?? null)
                            || filled($d['dt'] ?? null);
                    })
                    ->values()
                    ->all();

                return $machine;
            })->values()->all();

            return $tab;
        })->values()->all();

        $payload = ['tabs' => $tabs];

        if ((int) ($auth->user_type_id ?? 0) === 2) {
            $payload['user_id'] = $auth->id;
        }

        $request->merge($payload);

        $validatedData = $request->validate([
            //'user_id' => ['bail','required', 'integer', 'exists:users,id'],
            //'shift_id' => ['bail','required', 'integer', 'exists:shifts,id'],
            //'client_id' => ['bail','required', 'integer', 'exists:clients,id'],
            'branch_id' => ['bail','required', 'integer', 'exists:branches,id'],
            'branch_manager_id' => ['bail','required', 'integer', 'exists:branch_managers,id'],
            //'service_date' => ['bail','required', 'date_format:Y-m-d'],
            //'service_timezone' => ['bail','required', 'timezone'],
            
            'tabs' => ['bail','required', 'array', 'min:1'],
            'tabs.*.pieces' => ['bail','nullable', 'integer', 'min:0', 'max:999999999999'],
            'tabs.*.sogd' => ['bail','nullable', 'string', 'max:255'],
            'tabs.*.travel_time' => ['bail','nullable', 'integer', 'min:0', 'max:10080'],
            'tabs.*.time_on' => ['bail', 'nullable', 'numeric', 'decimal:0,2', 'gte:0', 'lte:9999999.99'],
            'tabs.*.report_type_id' => ['bail','required', 'integer', 'min:1', 'max:2'],
            'tabs.*.reported_error' => ['bail','nullable', 'string', 'max:255'],
            'tabs.*.code_id' => ['bail','nullable', 'integer', 'exists:codes,id'],
            'tabs.*.actions_taken' => ['bail','nullable', 'string', 'max:255'],
            'tabs.*.reported' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.arrival' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.departure' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.finished' => ['bail','nullable', 'date_format:Y-m-d H:i'],
            'tabs.*.status_id' => ['bail','nullable', 'integer', 'exists:statuses,id'],
            'tabs.*.is_tested' => ['bail','nullable', 'boolean'],
            'tabs.*.notes' => ['bail','nullable', 'string', 'max:255'],
            
            'tabs.*.service_parts' => ['bail','present', 'array'],
            'tabs.*.service_parts.*.id' => ['bail','required', 'integer', 'exists:parts,id'],
            'tabs.*.service_parts.*.quantity' => ['bail','required', 'integer', 'min:0', 'max:999999999999'],

            'tabs.*.machines' => ['bail','required','array','min:1'],
            'tabs.*.machines.*.machine_id' => ['bail','required', 'integer', 'exists:machines,id'],
            'tabs.*.machines.*.transport_1' => ['bail','nullable', 'decimal:0,1', 'gte:0', 'lte:9999.9'],
            'tabs.*.machines.*.transport_2' => ['bail','nullable', 'decimal:0,1', 'gte:0', 'lte:9999.9'],
            'tabs.*.machines.*.transport_3' => ['bail','nullable', 'decimal:0,1', 'gte:0', 'lte:9999.9'],
            'tabs.*.machines.*.dt' => ['bail','nullable', 'integer', 'min:0', 'max:999999'],
            'tabs.*.machines.*.signature_client_name' => ['bail','nullable', 'string', 'max:255'],

            'tabs.*.machines.*.machine_details'  => ['bail','present', 'array'],
            'tabs.*.machines.*.machine_details.*.module_id'  => ['bail','nullable', 'integer', 'exists:modules,id'],
            'tabs.*.machines.*.machine_details.*.failure_id'  => ['bail','nullable', 'integer', 'exists:failures,id'],
            'tabs.*.machines.*.machine_details.*.failure_type_id'  => ['bail','nullable', 'integer', 'exists:failure_types,id'],
            'tabs.*.machines.*.machine_details.*.dt' => ['bail','nullable', 'integer', 'min:0', 'max:999999'],
        ]);

        DB::beginTransaction();
        try {

            $serviceVisit->update([
                'branch_id'         => $validatedData['branch_id'],
                'branch_manager_id' => $validatedData['branch_manager_id'],
            ]);

            $reports = $serviceVisit->serviceReports()->orderBy('id')->get()->values();
            foreach ($validatedData['tabs'] as $i => $tab) {
                if (!isset($reports[$i])) {
                    break;
                }

                $report = $reports[$i];

                $attrs = Arr::only($tab, [
                    'pieces','sogd','time_on','travel_time','report_type_id','reported_error',
                    'code_id','actions_taken','reported','arrival','finished','departure',
                    'status_id','is_tested','notes',
                ]);

                // keep report metadata consistent with parent
                $attrs['branch_id']         = $validatedData['branch_id'];
                $attrs['branch_manager_id'] = $validatedData['branch_manager_id'];

                $report->parts()->delete();
                $parts = $tab['service_parts'] ?? [];

                if (!empty($parts)) {
                    $rows = [];
                    foreach ($parts as $p) {
                        $rows[] = [
                            'part_id'  => (int) $p['id'],
                            'quantity' => (int) $p['quantity'],
                        ];
                    }
                    if ($rows) {
                        $report->parts()->createMany($rows);
                    }
                }

                ServiceReportMachine::where('service_report_id', $report->id)->each(function ($pivot) {
                    $pivot->details()->delete();
                    $pivot->delete();
                });

                $machines = $tab['machines'] ?? [];
                foreach ($machines as $m) {
                    $pivot = ServiceReportMachine::create(array_merge(
                        Arr::only($m, [
                            'machine_id',
                            'transport_1', 'transport_2', 'transport_3',
                            'dt',
                            'signature_client_name',
                        ]),
                        ['service_report_id' => $report->id],
                    ));

                    $detailRows = [];
                    foreach (($m['machine_details'] ?? []) as $d) {
                        $detailRows[] = Arr::only($d, ['module_id', 'failure_id', 'failure_type_id', 'dt']);
                    }
                    if ($detailRows) {
                        $pivot->details()->createMany($detailRows);
                    }
                }
                
                $report->update($attrs);
            }

            $existingCount = $reports->count();
            $incomingCount = count($validatedData['tabs']);

            if ($incomingCount > $existingCount) {
                for ($i = $existingCount; $i < $incomingCount; $i++) {
                    $tab = $validatedData['tabs'][$i];

                    $reportAttrs = Arr::only($tab, [
                        'pieces','sogd','time_on','travel_time','report_type_id','reported_error',
                        'code_id','actions_taken','reported','arrival','finished','departure',
                        'status_id','is_tested','notes',
                    ]);

                    $newReport = $serviceVisit->serviceReports()->create(array_merge($reportAttrs, [
                        'complete_id'        => $serviceVisit->complete_id . '-' . ($i + 1),
                        'branch_manager_id'  => $validatedData['branch_manager_id'],
                        'user_id'            => $serviceVisit->user_id,     // keep consistent with parent
                        'service_date'       => $serviceVisit->service_date,
                        'service_timezone'   => 'N/A',
                        'shift_id'           => $serviceVisit->shift_id,
                        'branch_id'          => $validatedData['branch_id'],
                        'is_active'          => true,
                    ]));

                    $parts = $tab['service_parts'] ?? [];
                    if (!empty($parts)) {
                        $rows = [];
                        foreach ($parts as $p) {
                            $rows[] = [
                                'part_id'  => (int) $p['id'],
                                'quantity' => (int) $p['quantity'],
                            ];
                        }
                        if ($rows) {
                            $newReport->parts()->createMany($rows);
                        }
                    }

                    $machines = $tab['machines'] ?? [];
                    foreach ($machines as $m) {
                        $pivot = ServiceReportMachine::create(array_merge(
                            Arr::only($m, [
                                'machine_id',
                                'transport_1','transport_2','transport_3',
                                'dt',
                                'signature_client_name',
                            ]),
                            ['service_report_id' => $newReport->id],
                        ));

                        $detailRows = [];
                        foreach (($m['machine_details'] ?? []) as $d) {
                            $detailRows[] = Arr::only($d, ['module_id','failure_id','failure_type_id','dt']);
                        }
                        if ($detailRows) {
                            $pivot->details()->createMany($detailRows);
                        }
                    }
                }
            }
            /*
            in case system needs delete [NOT TESTED YET], it might be better just to update the is_active flag
            if ($incomingCount < $existingCount) {
                for ($j = $incomingCount; $j < $existingCount; $j++) {
                    $extra = $reports[$j];
                    $extra->parts()->delete();

                    ServiceReportMachine::where('service_report_id', $extra->id)
                    ->each(function ($pivot) {
                        $pivot->details()->delete(); // harmless if FK cascade exists
                        $pivot->delete();
                    });

                    $extra->delete();
                }
            }*/

            DB::commit();
            return to_route('service-visit.edit', ['service_visit' => $serviceVisit->id]);
        }catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceVisit $serviceVisit)
    {
        //
    }

    public function filterReports(Request $request)
    {
        $user = Auth::user();
        $filter = $request->input('filter');

        $baseQuery = ServiceVisit::query()
            ->where('is_active', true)
            ->tap(fn ($q) => $this->applyDateFilter($q, $filter))
            ->when($user->user_type_id !== 1, fn ($q) => $q->where('user_id', $user->id))
            ->select([
                'id',
                'complete_id',
                'user_id',
                'branch_id',
                'created_at',
            ])
            ->with([
                'user:id,nombre,apellido_paterno,apellido_materno',
                'branch:id,city_id',
                'branch.city:id,name,country_id',
            ])
            ->withCount('serviceReports')
            ->latest('created_at')
            ->get()
            ->each(fn ($report) => $report->setAttribute('user_full_name', $report->user->full_name))
            ->values();

        return Inertia::render('admin/reports/index', [
            'reports' => $baseQuery,
        ]);
    }

    public function closeReportVisit(ServiceVisit $serviceVisit){
        if($serviceVisit->closed) {
            return;
        }

        $serviceVisit->closed = true;
        $serviceVisit->save();

        return to_route('service-visit.edit', ['service_visit' => $serviceVisit->id]);
    }

    public function reOpenReportVisit(ServiceVisit $serviceVisit){
        if(!$serviceVisit->closed) {
            return;
        }

        $serviceVisit->closed = false;
        $serviceVisit->save();

        return to_route('service-visit.edit', ['service_visit' => $serviceVisit->id]);
    }

    protected function applyDateFilter($query, $filter){
        switch ($filter) {
            case '3months':
                $query->where('created_at', '>=', now()->subMonths(3));
            break;
            case 'all':
            break;
            default:
                $query->whereYear('created_at', $filter);
            break;
        }
    }
}
