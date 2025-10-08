<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ServiceReportsUnifiedExport implements FromCollection, WithHeadings, WithCustomCsvSettings
{
    public function __construct(
        private string $span = 'all'
    ) {
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $baseQuery = ServiceReport::query()->with([
            'user',
            'shift',
            'code',
            'branch',
            'branch.city',
            'branchManager',
            'status',
            'machines',
            'machineDetails',
            'machineDetails.serviceReportMachine',
            'machineDetails.serviceReportMachine.machine',
            'machineDetails.module',
            'machineDetails.failure',
            'machineDetails.failureType',
            'parts',
            'parts.part',
        ]);

        switch ($this->span) {
            case '3months':
                $baseQuery->where('created_at', '>=', now()->subMonths(3));
            break;
            case 'all':
            break;
            default:
                $baseQuery->whereYear('created_at', $this->span);
            break;
        }

        $reports = $baseQuery->orderBy('id')
            ->get();

        return $reports->map(function ($r) {
            $machinesRaw = $r->machines
                ->pluck('serial')
                ->filter()
                ->implode(', ');

            $machines = '="' . str_replace('"', '""', $machinesRaw) . '"';

            $errors = $r->machineDetails->map(function ($d) {
                $serial   = $d->serviceReportMachine?->machine?->serial ?? 'N/A';
                $error    = $d->module->es ?? $d->module->name ?? 'N/A';
                $cause    = $d->failure->es ?? $d->failure->name ?? 'N/A';
                $solution = $d->failureType->es ?? $d->failureType->name ?? 'N/A';
                $dt       = $d->dt;
                return "{$serial}: {$error} / {$cause} / {$solution} (dt: {$dt})";
            })->implode(' | ');

            $parts = $r->parts->map(function ($p) {
                $num  = $p->part->num_part ?? 'N/A';
                $desc = $p->part->descripcion ?? null;
                $qty  = $p->quantity;
                return $desc ? "{$num} x {$qty} ({$desc})" : "{$num} x {$qty}";
            })->implode(' | ');

            return [
                $r->id,
                $r->complete_id,
                $r->service_date,
                $r->closed ? 'Si' : 'No',
                trim(($r->user->nombre ?? '') . ' ' . ($r->user->apellido_paterno ?? '') . ' ' . ($r->user->apellido_materno ?? '')),
                $r->shift->name ?? 'N/A',
                $r->pieces,
                $r->sogd,
                $r->time_on,
                $r->travel_time,
                ($r->report_type_id === 1 ? 'Contrato' : 'Cliente'),
                $r->reported_error,
                $r->code->code ?? 'N/A',
                $r->branch->city->name ?? 'N/A',
                $r->branch->address ?? 'N/A',
                $r->branchManager->name ?? 'N/A',
                $r->branchManager->email ?? 'N/A',
                $r->branchManager->phone ?? 'N/A',
                $r->actions_taken,
                $r->reported,
                $r->arrival,
                $r->finished,
                $r->departure,
                $r->status->status ?? 'N/A',
                ($r->is_tested === 1 ? 'Si' : 'No'),
                $r->notes,
                $machines,
                $errors,
                $parts,
            ];
        });
    }

    public function headings(): array {
        return [
            'ID',
            'Nombre Archivo',
            'Fecha de Servicio',
            'Cerrado',
            'Ingeniero Asignado',
            'Turno',
            'Piezas',
            'SOGD',
            'Tiempo Encendido',
            'Tiempo de Viaje',
            'Tipo de Reporte',
            'Error Reportado',
            'Código',
            'Ciudad',
            'Dirección',
            'Gerente de Sucursal',
            'Email',
            'Teléfono',
            'Acciones Tomadas',
            'Reportado',
            'Arribo',
            'Finalizado',
            'Salida',
            'Estatus',
            'Prueba',
            'Notas',
            'Máquinas (seriales)',
            'Errores de Máquina',
            'Partes',
        ];
    }

    public function getCsvSettings(): array {
        return [
            'delimiter' => ',',
            'enclosure' => '"',
            'line_ending' => "\r\n",
            'use_bom' => true,
        ];
    }
}
