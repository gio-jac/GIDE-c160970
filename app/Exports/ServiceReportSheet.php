<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;

class ServiceReportSheet implements FromCollection, WithHeadings, WithColumnWidths, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceReport::select([
            'id',
            'complete_id',
            'service_date',
            'closed',
            'user_id',
            'shift_id',
            'pieces',
            'sogd',
            'time_on',
            'travel_time',
            'report_type_id',
            'reported_error',
            'code_id',
            'branch_id',
            'branch_manager_id',
            'actions_taken',
            'reported',
            'arrival',
            'finished',
            'departure',
            'status_id',
            'is_tested',
            'notes',
        ])->with([
            'user',
            'shift',
            'code',
            'branch',
            'branch.city',
            'branchManager',
            'status',
        ])->get()->map(function ($report) {
            return [
                'id' => $report->id,
                'complete_id' => $report->complete_id,
                'service_date' => $report->service_date,
                'closed' => $report->closed ? 'Si' : 'No',
                'user' => trim("{$report->user->nombre} {$report->user->apellido_paterno} {$report->user->apellido_materno}"),
                'shift' => $report->shift->name,
                'pieces' => $report->pieces,
                'sogd' => $report->sogd,
                'time_on' => $report->time_on,
                'travel_time' => $report->travel_time,
                'report_type' => $report->report_type_id === 1 ? 'Contrato' : 'Cliente',
                'reported_error' => $report->reported_error,
                'code' => $report->code->code ?? 'N/A',
                'branch_city' => $report->branch->city->name,
                'branch' => $report->branch->address,
                'branch_manager' => $report->branchManager->name,
                'branch_manager_email' => $report->branchManager->email,
                'branch_manager_phone' => $report->branchManager->phone,
                'actions_taken' => $report->actions_taken,
                'reported' => $report->reported,
                'arrival' => $report->arrival,
                'finished' => $report->finished,
                'departure' => $report->departure,
                'status' => $report->status->status ?? 'N/A',
                'is_tested' => $report->is_tested === 1 ? 'Si' : 'No',
                'notes' => $report->notes,
            ];
        })->sortBy('id');
    }

    public function headings(): array
    {
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
            'Código',
            'Ciudad',
            'Dirección',
            'Gerente de Sucursal',
            'Email',
            'Teléfono',
            'Acciones Tomadas',
            'Reportado',
            'Arribo',
            'Finalizado',
            'Salida',
            'Estatus',
            'Prueba',
            'Notas',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'G' => 13,
            'R' => 13,
        ];
    }

    public function title(): string
    {
        return 'Reports';
    }
}
