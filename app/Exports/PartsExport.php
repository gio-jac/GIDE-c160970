<?php

namespace App\Exports;

use App\Models\machine_reports\Part;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PartsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Part::select(['id','num_part','descripcion'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Numero de Parte',
            'Descripcion'
        ];
    }
}
