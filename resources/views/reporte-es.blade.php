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
            <td style="width:70%;text-align: left;">
                <p style="font-weight: normal;font-size:15px;">REPORTE DE SERVICIO</p>
                <p style="font-weight: normal;margin:0;">REPORTE ID:
                    {{ $report->id }}
                </p>
                <p style="font-weight: normal;margin-top:0;">NOMBRE DE ARCHIVO:
                    {{ $report->complete_id }}
                </p>
            </td>
            <td style="width:30%;">
                <img style="max-width:100%;" src="{{public_path('assets/images/icon/GD_Logo_BWM_pos_600.png')}}">
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td style="width:40%;">
                NOMBRE DEL CLIENTE:<br>
                {{ $report->branch->client->name }}
            </td>
            <td style="width:60%;">
                DIRECCIÓN:<br>
                {{ $report->branch->address }}
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td style="width:35%;">
                CONTACTO:<br>
                {{ $report->branch->branchManagers[0]->name }}
            </td>
            <td>
                MODELO DE MÁQUINA:<br>
                {{ $report->machines[0]->machine_model->model }}
            </td>
            <td>
                S/N:<br>
                {{ $report->machines[0]->serial }}
            </td>
            <td>
                TRANSPORTE:<br>
                {{ $report->machines[0]->pivot->transport_1 }}
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td>
                PIEZAS:<br>
                {{ $report->pieces }}
            </td>
            <td>
                MÁQUINA ON:<br>
                {{ $report->time_on }}
            </td>
            <td>
                TIEMPO DE VIAJE:<br>
                {{ $report->travel_time }}
            </td>
            @php
                $reportTypeId = $report->report_type_id;
            @endphp
            <td class="centered-cell{{ $reportTypeId === 1 ? ' highlighted' : '' }}">
                CONTRACT
            </td>
            <td class="centered-cell{{ $reportTypeId === 2 ? ' highlighted' : '' }}">
                CLIENT
            </td>
        </tr>
    </table>
    @php
        $module = [];
        $failure = [];
        $failureType = [];
        foreach($report->machineDetails as $detail){
            $module[] = !empty($detail['module']['name']) ? $detail['module']['name'] : 'N/A';
            $failure[] = !empty($detail['failure']['name']) ? $detail['failure']['name'] : 'N/A';
            $failureType[] = !empty($detail['failureType']['name']) ? $detail['failureType']['name'] : 'N/A';
        }
    @endphp
    <table class="tblStyle">
        <tr>
            <td>
                SO GD:<br>
                {{ $report->sogd }}
            </td>
            
            <td>
                ERROR:<br>
                {!! nl2br(implode("\n", $module)) !!}
            </td>
            <td>
                CAUSA:<br>
                {!! nl2br(implode("\n", $failure)) !!}
            </td>
            <td>
                SOLUCION:<br>
                {!! nl2br(implode("\n", $failureType)) !!}
            </td>
        </tr>
    </table>
    <div class="tblStyle reportedError">
        ERROR REPORTADO:<br>
        {{ $report->reported_error }}
    </div>

    <table style="margin:7px 0;">
        <tr>
            @php
                $codeId = $report->code_id;
            @endphp
            @foreach ($catalogCodes as $code)
                <td>
                    <div style="display: inline-block;width:20px;height:10px;margin-bottom: -2px;"
                        class="defaultBorder{{ $code->id === $codeId ? ' highlighted' : '' }}"></div>
                    {{ $code->code }}
                </td>
            @endforeach
        </tr>
    </table>
    <div class="tblStyle reportedError">
        ACCIONES TOMADAS:<br>
        {{ $report->actions_taken }}
    </div>

    <table style="text-align:center;margin:7px 0;">
        <tr>
            <td class="defaultBorder" colspan="2">REPORTADO</td>
            <td class="defaultBorder" colspan="2">HORA DE SALIDA</td>
            <td class="defaultBorder" colspan="2">HORA DE LLEGADA</td>
            <td class="defaultBorder" colspan="2">HORA DE FINALIZADO</td>
            <td>
                <div style="display: inline-block;width:20px;height:10px;margin-bottom: -2px;"
                    class="defaultBorder{{ $report->status_id === 1 ? ' highlighted' : '' }}"></div>
                COMPLETE
            </td>
            <td>
                <div style="display: inline-block;width:20px;height:10px;margin-bottom: -2px;"
                    class="defaultBorder{{ $report->is_tested === 1 ? ' highlighted' : '' }}"></div>
                TEST OK
            </td>
        </tr>
        <tr>
            <td class="defaultBorder">FECHA</td>
            <td class="defaultBorder">HORA</td>
            <td class="defaultBorder">FECHA</td>
            <td class="defaultBorder">HORA</td>
            <td class="defaultBorder">FECHA</td>
            <td class="defaultBorder">HORA</td>
            <td class="defaultBorder">FECHA</td>
            <td class="defaultBorder">HORA</td>
            <td>
                <div style="display: inline-block;width:20px;height:10px;margin-bottom: -2px;margin-left:-3px;"
                    class="defaultBorder{{ $report->status_id === 2 ? ' highlighted' : '' }}"></div>
                INCOMPLT
            </td>
            <td class="defaultBorder">DT</td>
        </tr>
        <tr>
            @php
                if (!function_exists('formatDateTime')) {
                    function formatDateTime($dateTime) {
                        if(empty($dateTime)) return ["N/A","N/A"];
                        $dateTimeParts = explode(" ", $dateTime);
                        $dateParts = explode("-", $dateTimeParts[0]);
                        $dateTimeParts[0] = $dateParts[2].'-'.$dateParts[1].'-'.$dateParts[0];
                        $dateTimeParts[1] = substr($dateTimeParts[1], 0, 5);
                        return $dateTimeParts;
                    }
                }

                $reported = formatDateTime($report->reported);
                $arrival = formatDateTime($report->arrival);
                $finished = formatDateTime($report->finished);
                $departure = formatDateTime($report->departure);
            @endphp

            <td class="defaultBorder">
                {{ $reported[0] }}
            </td>
            <td class="defaultBorder">
                {{ $reported[1] }}
            </td>
            <td class="defaultBorder">
                {{ $departure[0] }}
            </td>
            <td class="defaultBorder">
                {{ $departure[1] }}
            </td>
            <td class="defaultBorder">
                {{ $arrival[0] }}
            </td>
            <td class="defaultBorder">
                {{ $arrival[1] }}
            </td>
            <td class="defaultBorder">
                {{ $finished[0] }}
            </td>
            <td class="defaultBorder">
                {{ $finished[1] }}
            </td>
            <td>
                <div style="display: inline-block;width:20px;height:10px;margin-bottom: -2px;margin-left:-13px;"
                    class="defaultBorder{{ $report->status_id === 3 ? ' highlighted' : '' }}"></div>
                RETURN
            </td>
            <td class="defaultBorder">
                {{ $report->machines[0]->pivot->dt }}
            </td>
        </tr>
    </table>

    <table class="tblStyle" style="float: left;width: 48%;">
        <tr>
            <th>PIEZA REEMPLAZADA</th>
            <th>DESCRIPCIÓN</th>
            <th>CANT</th>
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
            <th>PIEZA REEMPLAZADA</th>
            <th>DESCRIPCIÓN</th>
            <th>CANT</th>
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
    <div class="tblStyle reportedError" style="margin:7px 0;">
        OBSERVACIONES:<br>
        {{ $report->notes }}
    </div>
    
    <div style="position: absolute; bottom: 0;width:100%;">
        <div class="defaultBorder" style="float: left;width: 48%;height:100px;">
            REALIZADO POR:
            <div style="width:100%;text-align:center;margin-top:70px;">{{ $report->user->nombre }} {{ $report->user->apellido_paterno }} {{ $report->user->apellido_materno }}</div>
        </div>

        <div class="defaultBorder" style="float: right;width: 48%;height:100px;">
            FIRMA DEL CLIENTE:
            <div style="width:100%;text-align:center;margin-top:70px;">{{ empty($report->machines[0]->pivot->signature_client_name) ? $report->branch->branchManagers[0]->name : $report->machines[0]->pivot->signature_client_name }}</div>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>

</html>