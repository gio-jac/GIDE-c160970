<?php

namespace App\Exports;

use App\Models\machine_reports\Part;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class PartsExport implements FromCollection, WithHeadings, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Part::select(['id','num_part','descripcion'])->get()->map(function ($part) {
            return [
                'id' => $part->id,
                'num_part' => $part->num_part,
                'descripcion' => $part->descripcion
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Numero de Parte',
            'Descripcion'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 20,  // Set column B width to 20
        ];
    }
}
