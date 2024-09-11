<?php

namespace App\Exports;

use App\Models\machine_reports\Part;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PartsExport implements FromCollection, WithHeadings, WithMapping
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

    public function map($row): array
    {
        return [
            $row->id,
            \PhpOffice\PhpSpreadsheet\Shared\StringHelper::formatValue($row->num_part),
            $row->descripcion,
        ];
    }
}
