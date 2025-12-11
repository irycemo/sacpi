<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invitación</title>
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

</style>

<body>

    <header>

            <img class="encabezado" src="{{ public_path('storage/img/encabezado.png') }}" alt="encabezado">

    </header>

    <footer>

        <div class="fot">
            <p>www.irycem.michoacan.gob.mx</p>
        </div>

    </footer>

    <main>

        <div>

            <p class="titulo">sistema para la administración de las contribuciones sobre la propiedad inmobiliaria</p>

            <p class="titulo">h. ayuntamiento constitucional de {{ $oficina }}</p>

        </div>

        <div class="informacion" style="margin-top: 20px;">

            <p class="parrafo">
                apreciable contribuyente, tu participación mediante el pago de las contribuciones a tu cargo, resulta fundamental para el desarrollo integral
                de nuestra población.
            </p>

            <p class="parrafo">
                de larevisión de nuestro sistema, se observa que a la fecha presenta un adeudo en el impuesto predial, por lo que se exhorta para que acuda a la
                brevedad posible a nuestras oficias a cumplir con su responsabilidad.
            </p>

        </div>

        <p class="separador">datos del predio</p>

        <div class="informacion">

            <p><strong>Propietario:</strong> {{ $predio->primerPropietario() }}</p>

            <p><strong>Ubicación del inmueble:</strong> {{ $predio->ubicacion() }}</p>

            <p><strong>Cuenta predial:</strong> {{ $predio->cuentaPredial() }}</p>

            <p><strong>Clave catastral:</strong> {{ $predio->claveCatastral() }}</p>

            <p><strong>Domicilio del propietario:</strong> {{ $predio->primerPropietarioDomicilio() }}</p>

        </div>

        <p class="separador">Adeudo</p>

        <div class="informacion">

            <table style="width: 100%;">

                <thead name="head">
                    <tr>

                        <th style="text-align: right;">Ejercicio Fiscal</th>
                        <th style="text-align: right;">Impuesto</th>
                        <th style="text-align: right;">Actualización</th>
                        <th style="text-align: right;">Recargos</th>
                        <th style="text-align: right;">Multas</th>
                        <th style="text-align: right;">Requerimientos</th>
                        <th style="text-align: right;">Subtotal</th>

                    </tr>

                </thead>

                <tbody name="body">

                    @foreach ($data as $item)

                        <tr>
                            <td style="text-align: right;">
                                {{ $item['ejercicio_fiscal'] }}
                            </td>
                            <td style="text-align: right;">
                                ${{ number_format($item['impuesto'], 4) }}
                            </td>
                            <td style="text-align: right;">
                                ${{ number_format($item['actualizacion'], 4) }}
                            </td>
                            <td style="text-align: right;">
                                ${{ number_format($item['recargos'], 4) }}
                            </td>
                            <td style="text-align: right;">
                                ${{ number_format($item['multas'], 4) }}
                            </td>
                            <td style="text-align: right;">
                                ${{ number_format($item['requerimientos'], 4) }}
                            </td>
                            <td style="text-align: right;">
                                ${{ number_format($item['subtotal'], 4) }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div>

            <table style="margin-top: 20px">

                <tbody>
                    <tr>

                        <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                            <p style="text-transform: uppercase; text-align: center; display: inline"></p>
                            <p style="text-align: center; border-top: black solid 1px;">Tesorero o Receptos (Nombre y firma)</p>

                        </td>

                    </tr>

                </tbody>

            </table>

            <div class="informacion">

                <p class="parrafo">
                    Con esta fecha recibi notificación en mi caracter  de _____________________ en la ciudad de ____________________, mich., a las _______
                    hrs. del día ____ del mes _____ de ________.
                </p>

            </div>

            <table style="margin-top: 20px">

                <tbody>
                    <tr>

                        <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                            <p style="text-transform: uppercase; text-align: center; display: inline"></p>
                            <p style="text-align: center; border-top: black solid 1px;">Nombre y firma del notificador</p>

                        </td>

                        <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                            <p style="text-transform: uppercase; text-align: center; display: inline"></p>
                            <p style="text-align: center;border-top: black solid 1px;">Recibi notificación (Nombre y firma)</p>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        <div class="informacion">

            <p class="parrafo">
                el adeudo incluye la cuenta corriente al día de hoy {{ now()->format('d/m/Y') }} es de: {{ $monto }}.
            </p>

        </div>

    </main>

</body>
</html>
