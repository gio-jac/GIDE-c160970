<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ServiceReportPartsSheet implements FromCollection, WithTitle, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceReport::select(['id', 'complete_id'])->with(['parts', 'parts.part'])->get()->flatMap(function ($report) {
            return $report->parts->map(function ($part) use ($report) {
                return [
                    'report_id' => $report->id,
                    'complete_id' => $report->complete_id,
                    'num_part' => $part->part->num_part,
                    'descripcion' => $part->part->descripcion,
                    'quantity'=> $part->quantity,
                ];
            });
        })->sortBy('report_id');
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
    
    public function headings(): array
    {
        return [
            'ID Reporte',
            'Nombre Archivo',
            'Número Parte',
            'Descripción',
            'Cantidad',
        ];
    }

    public function title(): string
    {
        return 'Parts';
    }
}
