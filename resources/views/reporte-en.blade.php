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
                <p style="font-weight: normal;font-size:15px;">SERVICE REPORT</p>
                <p style="font-weight: normal;margin:0;">REPORT ID:
                    {{ $report->id }}
                </p>
                <p style="font-weight: normal;margin-top:0;">FILE NAME:
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
                CUSTOMER NAME:<br>
                {{ $report->branch->client->name }}
            </td>
            <td style="width:60%;">
                ADDRESS:<br>
                {{ $report->branch->address }}
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td style="width:35%;">
                CONTACT:<br>
                {{ $report->branch->branchManagers[0]->name }}
            </td>
            <td>
                MACHINE MODEL:<br>
                {{ $report->machines[0]->machine_model->model }}
            </td>
            <td>
                S/N:<br>
                {{ $report->machines[0]->serial }}
            </td>
            <td>
                TRANSPORT:<br>
                {{ $report->machines[0]->pivot->transport_1 }}
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td>
                PIECES:<br>
                {{ $report->pieces }}
            </td>
            <td>
                MACHINE ON:<br>
                {{ $report->time_on }}
            </td>
            <td>
                TRAVEL TIME:<br>
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
        $dt = [];
        foreach($report->machineDetails as $detail){
            $module[] = !empty($detail['module']['name']) ? __('error.'.$detail['module']['id'],[],null,$detail['module']['name']) : 'N/A';
            $failure[] = !empty($detail['failure']['name']) ? __('failures.'.$detail['failure']['id'],[],null,$detail['failure']['name']) : 'N/A';
            $failureType[] = !empty($detail['failureType']['name']) ? __('failureType.'.$detail['failureType']['id'],[],null,$detail['failureType']['name']) : 'N/A';
            $dt[] = !empty($detail['dt']) ? $detail['dt'].' min.' : '0 min.';
        }
    @endphp
    <table class="tblStyle">
        <tr>
            <td>
                SO GD:<br>
                {{ $report->sogd }}
            </td>
            
            <td>
                MODULE:<br>
                {!! nl2br(implode("\n", $module)) !!}
            </td>
            <td>
                FAILURE:<br>
                {!! nl2br(implode("\n", $failure)) !!}
            </td>
            <td>
                FAULT SYMPTOM:<br>
                {!! nl2br(implode("\n", $failureType)) !!}
            </td>
            <td>
                DT (Min.):<br>
                {!! nl2br(implode("\n", $dt)) !!}
            </td>
        </tr>
    </table>
    <div class="tblStyle reportedError">
        REPORTED ERROR:<br>
        {{ $report->reported_error }}
    </div>

    <table style="margin:7px 0;">
        <tr>
            @php
                $codeId = $report->code_id;
            @endphp
            @foreach ($catalogCodes as $code)
                <td >
                    <div style="display: inline-block;width:20px;height:10px;margin-bottom: -2px;"
                        class="defaultBorder{{ $code->id === $codeId ? ' highlighted' : '' }}"></div>
                    {{ $code->code }}
                    @if ($code->id === $codeId)
                    <p style="margin: 0;padding:0;border:0;font-size:8px">{{ __('codes.'.$code->id,[],null, $code->code) }}</p>
                    @endif
                </td>
            @endforeach
        </tr>
    </table>
    <div class="tblStyle reportedError">
        ACTIONS TAKEN:<br>
        {{ $report->actions_taken }}
    </div>

    <table style="text-align:center;margin:7px 0;">
        <tr>
            <td class="defaultBorder" colspan="2">REPORTED</td>
            <td class="defaultBorder" colspan="2">DEPARTURE TIME</td>
            <td class="defaultBorder" colspan="2">ARRIVAL TIME</td>
            <td class="defaultBorder" colspan="2">FINISH TIME</td>
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
            <td class="defaultBorder">DATE</td>
            <td class="defaultBorder">HOUR</td>
            <td class="defaultBorder">DATE</td>
            <td class="defaultBorder">HOUR</td>
            <td class="defaultBorder">DATE</td>
            <td class="defaultBorder">HOUR</td>
            <td class="defaultBorder">DATE</td>
            <td class="defaultBorder">HOUR</td>
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
    <div class="tblStyle reportedError" style="margin:7px 0;">
        REMARKS:<br>
        {{ $report->notes }}
    </div>
    
    <div style="position: absolute; bottom: 0;width:100%;">
        <div class="defaultBorder" style="float: left;width: 48%;height:100px;">
            PERFOMED BY:
            <div style="width:100%;text-align:center;margin-top:70px;">{{ $report->user->nombre }} {{ $report->user->apellido_paterno }} {{ $report->user->apellido_materno }}</div>
        </div>

        <div class="defaultBorder" style="float: right;width: 48%;height:100px;">
            CUSTOMER SIGNATURE:
            <div style="width:100%;text-align:center;margin-top:70px;">{{ empty($report->machines[0]->pivot->signature_client_name) ? $report->branch->branchManagers[0]->name : $report->machines[0]->pivot->signature_client_name }}</div>
        </div>
        <div style="clear: both;"></div>
    </div>
</body>

</html>