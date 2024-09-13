<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServiceReportMachinesSheet implements FromCollection, WithHeadings, WithColumnWidths, WithTitle, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceReport::select(['id', 'complete_id'])->with(['machines'])->get()->flatMap(function ($report) {
            return $report->machines->map(function ($machine) use ($report) {
                return [
                    'report_id' => $report->id,
                    'complete_id' => $report->complete_id,
                    'serial' => $machine->serial,
                    'transport_1' => $machine->pivot->transport_1,
                    'transport_2' => $machine->pivot->transport_2,
                    'transport_3' => $machine->pivot->transport_3,
                    'dt' => $machine->pivot->dt,
                    'signature_client_name' => $machine->pivot->signature_client_name,
                ];
            });
        })->sortBy('report_id');
    }
    
    public function headings(): array
    {
        return [
            'ID Reporte',
            'Nombre Archivo',
            'Serial Maquina',
            'Transporte Inicial',
            'Transporte Final',
            'Tiempo Extra',
            'DT Final',
            'Nombre de Firma',
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
        return 'Machines';
    }
}
