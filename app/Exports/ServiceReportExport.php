<?php

namespace App\Exports;

use App\Models\machine_reports\ServiceReport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ServiceReportExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ServiceReport::all();
    }

    public function headings(): array
    {
        return [
            'id',
        ];
    }
}
