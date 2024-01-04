<!DOCTYPE html>
<html>

<head>
    <title>Nombre del Reporte</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        *{
            font-family: Arial, Helvetica, sans-serif;
            font-size:10px;
        }

        .tblStyle th, .tblStyle td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <td style="width:70%;text-align: left;">
                <p style="font-weight: normal;font-size:15px;">SERVICE REPORT</p>
                <p style="font-weight: normal;">REPORT ID: <?= $report->id ?></p>
            </td>
            <td style="width:30%;">
                <img style="max-width:100%;" src="{{public_path('assets/images/icon/Creating Confidence.svg')}}">
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td style="width:40%;">
                CUSTOMER NAME:<br><?= $report->machine->data_client->client->name ?>
            </td>
            <td style="width:60%;">
                ADDRESS:<br><?= $report->machine->data_client->address ?>
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td style="width:50%;">
                CONTACT:<br><?= $report->machine->data_client->contact ?>
            </td>
            <td>
                MACHINE MODEL:<br><?= $report->machine->machine_model->model ?>
            </td>
            <td>
                S/N:<br><?= $report->machine->serial ?>
            </td>
            <td>
                TRANSPORT:<br><?= $report->transport ?>
            </td>
        </tr>
    </table>
    <table class="tblStyle">
        <tr>
            <td>
                PIECES:<br><?= $report->pieces ?>
            </td>
            <td>
                MACHINE ON:<br><?= $report->time_on ?>
            </td>
            <td>
                TRAVEL TIME:<br><?= $report->travel_time ?>
            </td>
        </tr>
    </table>


    

    <!-- Aquí puedes agregar el contenido de tu reporte -->
    <p>id: <?= $report->id ?></p>
    <p>Customer Name: <?= $report->machine->data_client->client->name ?></p>
    <p>Address: <?= $report->machine->data_client->address ?></p>
    <p>Contact: <?= $report->machine->data_client->contact ?></p>
    <p>Serial: <?= $report->machine->serial ?></p>
    <table>
        <thead>
            <tr>
                <th>Num Parte</th>
                <th>Descripcion</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
        @foreach($report->parts as $part)
        <tr>
            <td>{{$part->part_id}}</td>
            <td>{{$part->part->descripcion}}</td>
            <td>{{$part->quantity}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
</body>

</html>