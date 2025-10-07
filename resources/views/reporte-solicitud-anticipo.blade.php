<!DOCTYPE html>
<html>

<head>
    <title>SOLICITUD Y AUTORIZACIÓN DE ANTICIPO</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        * {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
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
            <td style="width:30%;">
                <img style="max-width:100%;" src="{{public_path('assets/images/icon/GD_Logo_BWM_pos_600.png')}}">
            </td>
            <td style="width:70%;text-align: right;">
                <p style="font-weight: 700;font-size:15px;">FORMATO SOLICITUD Y AUTORIZACIÓN DE ANTICIPO</p>
            </td>
            
        </tr>
    </table>
    <br>
    <table style="margin-top: 20px">
        <tr>
            <td style="width:40%;">
                <b>NO. EMPLEADO:</b><br>
                {{ $advanceRequest[0]->emp }}
            </td>
            <td style="width:60%;">
                <b>NOMBRE:</b><br>
                {{ $advanceRequest[0]->nombre }} {{ $advanceRequest[0]->apellido_paterno }} {{ $advanceRequest[0]->apellido_materno }}
            </td>
        </tr>
    </table> 
    <br>
    <table style="margin-top: 20px">
        <tr>
            <td style="width:40%;">
                <b>DEPARTAMENTO:</b><br>
                {{ $advanceRequest[0]->department }} 
            </td>
            <td style="width:60%;">
                <b>CENTRO DE COSTOS:</b><br>
                {{ $advanceRequest[0]->cc }} {{ $advanceRequest[0]->costCenter }} 
            </td>
        </tr>
    </table>
    <br>
    <table  class="tblStyle" style="margin-top: 20px">
        <tr>
            <td style="width:35%;">
                
            </td>
            <td style="width:35%;"><b>FECHA:</b></td>
        </tr>
        <tr>
            <td style="width:35%;">
            <b>SOLICITUD:</b>
            </td>
            <td style="width:35%;">
                {{ $advanceRequest[0]->requestDate }}
            </td>
        </tr>
        <tr>
            <td style="width:35%;">
            <b>DEPOSITO:</b>
            </td>
            <td style="width:35%;">
                {{ $advanceRequest[0]->depositDate }}
            </td>
        </tr>
    </table>
    <br>
    <table class="tblStyle" style="margin-top: 20px">
        <tr>
            <td style="width:33%;">
                <b>ORIGEN:</b>
            </td>
            <td style="width:33%;">
                <b>DESTINO:</b>
            </td>
            <td style="width:34%;">
                <b>CONCEPTO DE TESORERIA:</b>
            </td>
        </tr>
        <tr>
            <td style="width:33%;">
                {{ $advanceRequest[0]->destinyFrom }}
            </td>
            <td style="width:33%;">
                {{ $advanceRequest[0]->destinyTo }}
            </td>
            <td style="width:34%;">
                {{ $advanceRequest[0]->reference }}
            </td>
        </tr>
        <tr>
            <td style="width:33%;">
                {{ $advanceRequest[0]->destinyTo }}
            </td>
            <td style="width:33%;">
                {{ $advanceRequest[0]->destinyFrom }}
            </td>
            <td style="width:34%;">
                {{ $advanceRequest[0]->reference }}
            </td>
        </tr>
    </table>
    <br>
    <table style="margin-top: 20px">
        <tr>
            <td style="width:20%;">
                <b>MOTIVO DEL VIAJE:</b><br>
            </td>
            <td style="width:80%;">
                {{ $advanceRequest[0]->purposeTravel }} 
            </td>
        </tr>
        <tr>
            <td style="width:20%;">
                <b>ANTICIPO:</b><br>
            </td>
            <td style="width:80%;">
                ${{ $advanceRequest[0]->payAdvance }} 
            </td>
        </tr>
        <tr>
            <td style="width:20%;">
                <b>COMENTARIOS:</b><br>
            </td>
            <td style="width:80%;">
                {{ $advanceRequest[0]->coment }} 
            </td>
        </tr>
    </table> <br>

    <table style="margin-top: 200px; width: 100%;">
        <tr>
            <td style="width: 33%; position: static; text-align: -webkit-center;">
               
            </td>
            <td style="width: 33%; text-align: -webkit-center;">
                <div style=" width:200px; text-align: center; border-top: solid 1px;">
                    AUTORIZADO POR <br> {{ $advanceRequest[0]->approveBy}}
                </div>
            </td>
            <td style="width: 33%; position: static; text-align: -webkit-center;">
                
            </td>
        </tr>
        
    </table> <br>
</body>

</html>