<?php

namespace App\Exports;

use App\Models\machine_reports\Machine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MachinesExport implements FromCollection, WithHeadings
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
}
