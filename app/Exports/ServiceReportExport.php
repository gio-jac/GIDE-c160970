<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ServiceReportExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Reports' => new ServiceReportSheet(),
            'Machines' => new ServiceReportMachinesSheet(),
            'Machines Errors' => new ServiceReportMachinesErrorsSheet(),
            'Parts' => new ServiceReportPartsSheet(),
        ];
    }
}
