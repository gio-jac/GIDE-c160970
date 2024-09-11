<?php

namespace App\Exports;

use App\Models\machine_reports\Machine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MachinesExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Machine::with(["machine_model","machine_model.model_segment","production_line"])->get()->map(function ($machine) {
            return [
                'id' => $machine->id,
                'serial' => $machine->serial,
                'production_line' => $machine->production_line->name,
                'client' => $machine->client->name,
                'machine_model' => $machine->machine_model->model,
                'segment' => $machine->machine_model->model_segment->segment,
                'line_num' => $machine->line_num ?? 'N/A'
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Serial',
            'Linea Producción',
            'Cliente',
            'Modelo Maquina',
            'Segmento',
            'Numero de Linea'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 20,  // Set column B width to 20
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            'B' => ['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT]],
        ];
    }
}
