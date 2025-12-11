<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aviso</title>
</head>

<style>
    header{
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 100px;
        text-align: center;
    }

    header img{
        height: 100px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }


    body{
        margin-top: 120px;
        margin-bottom: 40px;
        counter-reset: page;
        height: 100%;
        background-image: url("storage/img/escudo_fondo.png");
        background-size: cover;
        background-position: 0 -50px !important;
        font-family: sans-serif;
        font-weight: normal;
        line-height: 1.5;
        text-transform: uppercase;
        font-size: 9px;
    }

    .center{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

    .container{
        display: flex;
        align-content: space-around;
    }

    .parrafo{
        text-align: justify;
    }

    .firma{
        text-align: center;
    }

    .control{
        text-align: center;
    }

    .atte{
        margin-bottom: 10px;
    }

    .borde{
        display: inline;
        border-top: 1px solid;
    }

    .tabla{
        width: 100%;
        font-size: 10px;
        margin-bottom: 30px;;
        margin-left: auto;
        margin-right: auto;
    }

    footer{
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        background: #5E1D45;
        color: white;
        font-size: 12px;
        text-align: right;
        padding-right: 10px;
        text-transform: lowercase;
    }

    .fot{
        display: flex;
        padding: 2px;
        text-align: center;
    }

    .fot p{
        display: inline-block;
        width: 33%;
        margin: 0;
    }

    .qr{
        display: block;
    }

    .no-break{
        page-break-inside: avoid;
    }

    table{
        margin-bottom: 5px;
        margin-left: auto;
        margin-right: auto;
    }

    .separador{
        text-align: justify;
        border-bottom: 1px solid black;
        padding: 0 20px 0 20px;
        border-radius: 25px;
        border-color: gray;
        letter-spacing: 5px;
        margin: 0 0 5px 0;
    }

    .titulo{
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        margin: 0;
    }

    .imagenes{

        max-width: 100%;

    }

</style>

<body>

    <header>

            <img class="encabezado" src="{{ public_path('storage/img/encabezado.png') }}" alt="encabezado">

    </header>

    <footer>

        <div class="fot">
            <p>sacpi.michoacan.gob.mx</p>
        </div>

    </footer>

    <main>

        <p class="separador"><strong>RECIBO DE PAGO DE ISAI</strong></p>

        <div class="informacion" >

            <p>
                <strong>Tipo de comprobante: </strong> Recibo <br>
                <strong>Folio del recibo: </strong> {{ $datos['foliorecibo'] }} <br>
                <strong>Fecha y hora de emisión: </strong> {{ $datos['fechayhora'] }} <br>
                <strong>Metodo de pago: </strong> EFECTIVO <br>
                <strong>Forma de pago: </strong> UNA SOLA EXHIBICIÓN <br>



                {{-- <strong>Declarante:</strong>

                @if($aviso->entidad->numero_notaria)
                    {{ $aviso->entidad->notarioTitular->name }}
                @else
                    {{ $aviso->entidad->dependencia }}
                @endif,

                <strong>cuenta predial:</strong> {{ $aviso->predio->cuentaPredial() }},

                <strong>Clave catastral:</strong> {{ $aviso->predio->claveCatastral() }} --}}
            </p>

        </div>

        <p class="separador"><strong>DATOS DEL PREDIO</strong></p>

        <div class="informacion" >

            <p>
                <strong>Nombre del Contribuyente: </strong> {{ $datos['contribuyente'] }} <br>
                <strong>Cuenta predial: </strong> {{ $datos['cuenta_predial'] }} <br>
                <strong>Clave Catastral: </strong> {{ $datos['clave_catastral'] }} <br>
                <strong>Valor Catastral: </strong> $ {{ number_format($datos['valor_catastral'],2) }} <br>
                <strong>Concepto de pago: </strong> IMPUESTO SOBRE ADQUISICIÓN DE INMUEBLES (ISAI) <br>
                <strong>UBICACIÓN DEL PREDIO: </strong> {{ $datos['ubicacion_predio'] }} <br>
                <strong>DOMICILIO PARA RECIBIR NOTIFICACIONES: </strong> {{ $datos['notificacion'] }} <br>


            </p>

        </div>

        <p class="separador"><strong>DETALLE DEL PAGO</strong></p>

        <table style="border: 1px solid black; border-collapse: collapse">

            <thead>

                <tr>
                    <th style="border: 1px solid black;">Clave</th>
                    <th style="border: 1px solid black;">Descripción</th>
                    <th style="border: 1px solid black;">Importe</th>
                </tr>

            </thead>

            <tbody>



                    <tr>
                        <td style="padding-right: 40px; border: 1px solid black;">
                            010101
                        </td>
                        <td style="padding-right: 100px; border: 1px solid black;">
                            Impuesto
                        </td>
                        <td style="padding-left: 40px; text-align:right; border: 1px solid black;">
                            {{ number_format($datos['impuesto'],2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-right: 40px; border: 1px solid black;">
                            010101
                        </td>
                        <td style="padding-right: 100px; border: 1px solid black;">
                            Actualización
                        </td>
                        <td style="padding-left: 40px; text-align:right; border: 1px solid black;">
                            {{ number_format($datos['actualizacion'],2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-right: 40px; border: 1px solid black;">
                            090401
                        </td>
                        <td style="padding-right: 100px; border: 1px solid black;">
                            Recargo
                        </td>
                        <td style="padding-left: 40px; text-align:right; border: 1px solid black;">
                            {{ number_format($datos['recargos'],2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-right: 40px; border: 1px solid black;">
                            090104
                        </td>
                        <td style="padding-right: 100px; border: 1px solid black;">
                            Multa
                        </td>
                        <td style="padding-left: 40px; text-align:right; border: 1px solid black;">
                            {{ number_format($datos['multas'],2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-right: 40px; border: 1px solid black;">

                        </td>
                        <td style="padding-right: 100px; border: 1px solid black;">
                            <strong>Total</strong>
                        </td>
                        <td style="padding-left: 40px; text-align:right; border: 1px solid black;">
                            {{ number_format($datos['total'],2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:center;">
                            {{ $datos['importeletra'] }}
                        </td>

                    </tr>





            </tbody>

        </table>
        <br>
        <br>

        <p class="separador"><strong>INFORMACIÓN DE LA TESORERÍA MUNICIPAL O DE LA OFICINA RECAUDADORA</strong></p>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>

        <p class="separador"><strong>SELLO</strong></p>

    </main>

</body>
</html>
