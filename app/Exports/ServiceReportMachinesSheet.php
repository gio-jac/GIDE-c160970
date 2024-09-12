<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ServiceReportMachinesSheet implements FromCollection, WithHeadings, WithTitle
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
                    'machine_id' => $machine->serial,
                    'transport_time_1' => $machine->pivot->transport_time_1,
                    'transport_time_2' => $machine->pivot->transport_time_2,
                    'transport_1' => $machine->pivot->transport_1,
                    'transport_2' => $machine->pivot->transport_2,
                    'transport_3' => $machine->pivot->transport_3,
                    'dt' => $machine->pivot->dt,
                    'signature_client_name' => $machine->pivot->signature_client_name,
                ];
            });
        });
    }
    
    public function headings(): array
    {
        return [
            'Report ID',
            'Complete ID',
            'Machine ID',
            'Transport Time 1',
            'Transport Time 2',
            'Transport 1',
            'Transport 2',
            'Transport 3',
            'DT',
            'Signature Client Name',
        ];
    }

    public function title(): string
    {
        return 'Machines';
    }
}
