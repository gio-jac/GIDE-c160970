<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceReportPartsSheet implements FromCollection, WithTitle, WithHeadings
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
        });
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
