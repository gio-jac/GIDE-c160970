<!DOCTYPE html>
<html>

<head>
    <title>Nombre del Reporte</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        .tblStyle th,
        .tblStyle td,
        .defaultBorder {
            border: 1px solid black;
        }

        .tblStyle.reportedError {
            border: 1px solid black;
            height: 75.8px;
        }

        .countTime{
            background-color: #dedede;
        }

        .centered-cell {
            text-align: center;
            width: 75px;
        }

        .highlighted {
            background-color: #9e9e9e;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="width:50%; text-align:center;">
                <img style="max-width:50%;" src="{{public_path('assets/images/icon/GD_Logo_BWM_pos_600.png')}}">
            </td>
            <td style="width:50%;text-align: center;">
                <p style="font-weight: normal;">REPORT ID:
                    {{ $report->complete_id }}
                </p>
            </td>
        </tr>
    </table>

    <table class="tblStyle" style="float: left;width: 56%;">
        <tr>
            <td style="min-width:100px;text-align:center;">Cliente:</td>
            <td>{{ $report->branch->client->name }}</td>
        </tr>
        <tr>
            <td style="text-align:center;">Direccion:</td>
            <td>{{ $report->branch->address }}</td>
        </tr>
        <tr>
            <td style="text-align:center;">Telefono:</td>
            <td>{{ $report->branch->branchManagers[0]->phone }}</td>
        </tr>
        <tr>
            <td style="text-align:center;">No. serie:</td>
            <td>
                {{ implode(', ', $report->machines->pluck('serial')->toArray()) }}
            </td>
        </tr>
        <tr>
            <td style="text-align:center;">Equipos:</td>
            <td>
                {{ implode(', ', $report->machines->pluck('machine_model.model')->toArray()) }}
            </td>
        </tr>
    </table>

    <table class="tblStyle" style="float: right;width: 40%;">
    @php
        $codeId = $report->code_id;
    @endphp
    @foreach ($catalogCodes as $code)
        <tr class="{{ $code->id === $codeId ? ' highlighted' : '' }}">
            <td>{{ $code->code }}</td>
            <td>{{ $code->description }}</td>
        </tr>
    @endforeach
    </table>
    <div style="clear: both;"></div>
    <p style="margin-bottom:0px;">Descripcion del problema:</p>
    <table class="tblStyle">
        @foreach ($report->machines as $machines)
        <tr>
            <td>{{ $machines->serial }}</td>
            <td>{{ empty($machines->pivot->module->name) ? "N/A" : $machines->pivot->module->name }}</td>
            <td>{{ empty($machines->pivot->failure->name) ? "N/A" : $machines->pivot->failure->name}}</td>
            <td>{{ empty($machines->pivot->failure_type->name) ? "N/A" : $machines->pivot->failure_type->name}}</td>
        </tr>
        @endforeach
    </table>
    <p style="margin-bottom:0px;">Solución/Comentarios:</p>
    <div class="tblStyle reportedError">
        {{ $report->actions_taken }}
    </div>

    <div style="clear: both;"></div>
        <p></p>
    <table style="float: left;width: 40%;text-align:center;">
        @php
            if (!function_exists('formatDateTime2')) {
                function formatDateTime2($dateTime) {
                    if(empty($dateTime)) return ["N/A","N/A"];
                    $dateTimeParts = explode(" ", $dateTime);
                    $dateParts = explode("-", $dateTimeParts[0]);
                    $months = array(1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic');
                    $monthName = $months[(int)$dateParts[1]]; // Convertir el número del mes a nombre
                    $dateTimeParts[0] = $dateParts[2].'-'.$monthName.'-'.$dateParts[0];
                    $dateTimeParts[1] = substr($dateTimeParts[1], 0, 5);
                    return $dateTimeParts;
                }
            }
            $arrival = formatDateTime2($report->arrival);
            $finished = formatDateTime2($report->finished);
        @endphp
        <tr>
            <td class="defaultBorder" colspan="2">Llegada al sitio</td>
            <td class="defaultBorder" colspan="2">Cierre del reporte</td>
        </tr>   
        <tr>
            <td class="defaultBorder">Fecha</td>
            <td class="defaultBorder">Hora</td>
            <td class="defaultBorder">Fecha</td>
            <td class="defaultBorder">Hora</td>
        </tr> 
        <tr>
            <td class="defaultBorder">{{ $arrival[0] }}</td>
            <td class="defaultBorder">{{ $arrival[1] }}</td>
            <td class="defaultBorder">{{ $finished[0] }}</td>
            <td class="defaultBorder">{{ $finished[1] }}</td>
        </tr> 
    </table>

    <table class="tblStyle" style="float: right;width: 58%;text-align:center;">
        <tr>
            <td></td>
            <td>Transporte</td>
            <td>Cantidad</td>
            <td>Total</td>
        </tr>
        @foreach ($report->machines as $machine)
        <tr @if($loop->index % 2 == 1) class="countTime" @endif>
            <td rowspan="2">{{ $machine->serial }}</td>
            <td>{{ $machine->pivot->transport_time_1 }}</td>
            <td>{{ $machine->pivot->transport_1 }}</td>
            <td rowspan="2">{{ $machine->pivot->transport_1 + $machine->pivot->transport_2 }}</td>
        </tr>
        <tr @if($loop->index % 2 == 1) class="countTime" @endif>
            <td>{{ $machine->pivot->transport_time_2 }}</td>
            <td>{{ $machine->pivot->transport_2 }}</td>
        </tr>
        @endforeach
    </table>
    
    <div style="clear: both;"></div>
    <p></p>
    <table class="tblStyle" style="float: left;width: 48%;">
        <tr>
            <th>PART REPLACED</th>
            <th>DESCRIPTION</th>
            <th>QTY</th>
        </tr>
        @foreach($report->parts as $part)
            @if($loop->index % 2 != 1)
            <tr style="text-align:center;">
                <td>{{$part->part->num_part}}</td>
                <td>{{$part->part->descripcion}}</td>
                <td>{{$part->quantity}}</td>
            </tr>
            @endif
        @endforeach
    </table>

    <table class="tblStyle" style="float: right;width: 48%;">
        <tr>
            <th>PART REPLACED</th>
            <th>DESCRIPTION</th>
            <th>QTY</th>
        </tr>
        @foreach($report->parts as $part)
            @if($loop->index % 2 == 1)
            <tr style="text-align:center;">
                <td>{{$part->part->num_part}}</td>
                <td>{{$part->part->descripcion}}</td>
                <td>{{$part->quantity}}</td>
            </tr>
            @endif
        @endforeach
    </table>
    <div style="clear: both;"></div>
    <p style="margin-bottom:0px;">Tiempos muertos:</p>
    @foreach ($report->machines as $machine)
        <table class="tblStyle" style="float: left;width: 200px;margin-right:10px;margin-bottom:10px;text-align:center;">
            <tr>
                <td style="width:100px;">{{ $machine->serial }}</td>
                <td>{{ $machine->pivot->dt }}</td>
            </tr>
        </table>
    @endforeach
    <div style="clear: both;"></div>
        
    <div style="position: absolute; bottom: 0;width:100%;">
        @php 
            $signatureNumber = !empty($report->signature_client_name_2) ? 3 : 2;
            $widthPercentage = 92 / $signatureNumber;
            $widthcss = $widthPercentage . "%";
        @endphp
        <div class="defaultBorder" style="float: left;width: {{ $widthcss }};height:100px;margin:0px 10px;text-align:center;">
            PERFOMED BY:
            <div style="width:100%;text-align:center;margin-top:70px;">{{ $report->user->nombre }} {{ $report->user->apellido_paterno }} {{ $report->user->apellido_materno }}</div>
        </div>

        <div class="defaultBorder" style="float: left;width: {{ $widthcss }};height:100px;margin:0px 10px;text-align:center;">
            OPERADOR {{ $report->machines[0]->serial }}:
            <div style="width:100%;text-align:center;margin-top:70px;">{{ empty($report->signature_client_name_1) ? $report->branch->branchManagers[0]->name : $report->signature_client_name_1 }}</div>
        </div>
        
        @if($signatureNumber === 3)
        <div class="defaultBorder" style="float: left;width: {{ $widthcss }};height:100px;margin:0px 10px;text-align:center;">
            OPERADOR {{ $report->machines[1]->serial }}:
            <div style="width:100%;text-align:center;margin-top:70px;">{{ empty($report->signature_client_name_2) ? $report->branch->branchManagers[0]->name : $report->signature_client_name_2 }}</div>
        </div>
        @endif
        <div style="clear: both;"></div>
    </div>
</body>

</html>