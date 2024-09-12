<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServiceReportMachinesErrorsSheet implements FromCollection, WithTitle, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceReport::with(['machineDetails', 'machineDetails.serviceReportMachine', 'machineDetails.serviceReportMachine.machine','machineDetails.module', 'machineDetails.failure', 'machineDetails.failureType'])->get()->flatMap(function ($report) {
            return $report->machineDetails->map(function ($detail) use ($report) {
                return [
                    'report_id' => $report->id,
                    'complete_id' => $report->complete_id,
                    'serial' => $detail->serviceReportMachine->machine->serial,
                    'error' => $detail->module->es ?? $detail->module->name ?? 'N/A',
                    'cause' => $detail->failure->es ?? $detail->failure->name ?? 'N/A',
                    'solution' => $detail->failureType->es ?? $detail->failureType->name ?? 'N/A',
                    'dt' => $detail->dt
                ];
            });
        });
    }

    public function headings(): array
    {
        return [
            'ID Reporte',
            'Nombre Archivo',
            'Serial Maquina',
            'Error',
            'Causa',
            'Solución',
            'DT',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'C' => 20,  // Set column B width to 20
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'C' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT]],
        ];
    }
    
    public function title(): string
    {
        return 'Machines Errors';
    }
}
