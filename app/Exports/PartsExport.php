<?php

namespace App\Exports;

use App\Models\machine_reports\Part;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PartsExport implements FromCollection, WithHeadings, WithColumnFormatting
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

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
