<!DOCTYPE html>
<html>

<head>
    <title>Nombre del Reporte</title>
    <style>
        /* Aquí puedes agregar tus estilos CSS */
    </style>
</head>

<body>
    <img style="width:250px;height;200px;" src="{{public_path('assets/images/icon/Creating Confidence.svg')}}">

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