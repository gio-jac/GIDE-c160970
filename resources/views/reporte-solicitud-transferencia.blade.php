<!DOCTYPE html>
<html>

<head>
    <title>SOLICITUD DE TRANSFERENCIA</title>
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
                <p style="font-weight: 700;font-size:15px;">SOLICITUD DE TRANSFERENCIA</p>
                <br>
                <b>FECHA: {{ date('d-m-Y') }}</b>
            </td>
        </tr>
    </table>
    <br>
    <table style="margin-top: 20px">
        <tr>
            <td style="width:100%;">
                <b>A NOMBRE:</b>
                {{ $expenses->nombre }} {{ $expenses->apellido_paterno }} {{ $expenses->apellido_materno }}
            </td>
        </tr>
    </table> 
    <table style="margin-top: 20px">
        <tr>
            <td style="width:100%;">
                <b>POR LA CANTIDAD DE:</b> ${{ $expenses->payToReturn }} ({{ $payToReturn }} pesos {{ $cents }}/100 M.N.) 
                
            </td>
        </tr>
    </table>
    <table style="margin-top: 20px">
        <tr>
            <td style="width:50%;">
                <b>CENTRO DE COSTOS:</b> {{ $expenses->cc }} {{ $expenses->costCenter }} 
            </td>
            <td style="width:50%;">
                <b>DEPTO. SOLICITANTE:</b> {{ $expenses->department }} 
            </td>
        </tr>
    </table>
    <table style="margin-top: 20px">
        <tr>
            <td style="width:50%;">
                <b>POR CONCEPTO DE: </b> {{ $expenses->purposeTravel }} 
            </td>
            <td style="width:50%;">
                <b>{{ $expenses->reference }}</b>
            </td>
        </tr>
    </table>
    <br>
    <table class="tblStyle" style="margin-top: 20px">
        <tr>
            <td style="width:65%;">
                <b>CONCEPTO</b>
            </td>
            <td style="width:35%; text-align: center;">
                <b>MONTO ($)</b>
            </td>
            <td style="width:10%; text-align: center;">
                <b>HABER</b>
            </td>
        </tr>
        <tr>
            <td style="width:65%; ">
                ANTICIPO
            </td>
            <td style="width:35%; text-align: right;">
                ${{ $expenses->payAdvance }}
            </td>
            <td style="width:10%; text-align: right;">
                MXP
            </td>
        </tr>
        <tr>
            <td style="width:65%;">
                GASTOS
            </td>
            <td style="width:35%; text-align: right;">
                ${{ $expenses->totalExpense }}
            </td>
            <td style="width:10%; text-align: right;">
                MXP
            </td>
        </tr>
        <tr>
            <td style="width:65%;">
            @if ($expenses->totalExpense > $expenses->payAdvance )
                <label>TOTAL A FAVOR</label>
            @endif
            @if ($expenses->totalExpense < $expenses->payAdvance )
                <label>TOTAL EN CONTRA</label>
            @endif
            @if ($expenses->totalExpense == $expenses->payAdvance )
                <label>TOTAL</label>
            @endif
            </td>
            <td style="width:25%; text-align: right;">
                ${{ $expenses->payToReturn }}
            </td>
            <td style="width:10%; text-align: right;">
                MXP
            </td>
        </tr>
    </table>

    <table style="margin-top: 20px">
        <tr>
            <td style="width:100%;">
                <b>NOTA:</b>
                {{ $expenses->concept }} 
            </td>
        </tr>
    </table>

    <table style="margin-top: 200px; width: 100%;">
        <tr>
            <td style="width: 33%; position: static; text-align: -webkit-center;">
               
            </td>
            <td style="width: 33%; text-align: -webkit-center;">
                <div style=" width:200px; text-align: center; border-top: solid 1px;">
                    AUTORIZADO POR <br> {{ $expenses->approveBy}}
                </div>
            </td>
            <td style="width: 33%; position: static; text-align: -webkit-center;">
                
            </td>
        </tr>
        
    </table> <br>
       
</body>

</html>