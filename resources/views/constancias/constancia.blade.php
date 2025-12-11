<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Constancia</title>
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

            <p class="titulo">h. ayuntamiento constitucional de {{ $oficina->nombre }}</p>

            <p class="titulo">Constancia de no adeudo</p>

        </div>

        <p class="parrafo" style="text-align:right;">
            <strong>Folio:</strong> {{ $constancia->año }}-{{ $constancia->folio }}-{{ $constancia->año }}
        </p>

        <div class="informacion" style="margin-top: 20px;">

            <p class="parrafo">
                con fundamento en lo dispuesto por los artículos 162 al 166 de la ley de hacienda municipal del estado de michoacán de ocampo; se exipde la siguiente constancia:
            </p>

        </div>

        <p class="separador">datos del predio</p>

        <div class="informacion">

            <p><strong>Propietario:</strong> {{ $predio->primerPropietario() }}</p>

            <p><strong>Cuenta predial:</strong> {{ $predio->cuentaPredial() }}</p>

            <p><strong>Clave catastral:</strong> {{ $predio->claveCatastral() }}</p>

            <p><strong>Tipo de predio:</strong> {{ $predio->tipo_predio == 1 ? 'Urbano' : 'Rustico' }}</p>

            <p><strong>Valor catastral:</strong> ${{ number_format($predio->valor_catastral, 2) }}</p>

            <p><strong>Ubicación del inmueble:</strong> {{ $predio->ubicacion() }}</p>

        </div>

        @if($predio->exento)

            <p class="parrafo">
                el que suscribe, tesorero municipal de este h. ayuntamiento, hace constar que el predio citado en antecedentes se encuentra exento de pago de impuesto predial por encontrarse en el supuesto del artículo 34 de la ley de hacienda municipal del estado de michoacán de ocampo.
            </p>

        @else

            @if($predio->pagos->count() === 0 && $predio->created_at < now()->endOfYear()->subMonths(2))

                <p class="parrafo">
                    el que suscribe, tesorero municipal de este h. ayuntamiento, hace constar que el predio citado en antecedentes, al sexto bimestre del presente año, no ha causado impuesto predial
                </p>

            @else

                <p class="parrafo">
                    el que suscribe, tesorero municipal de este h. ayuntamiento, hace constar que el predio citado en antecedentes se encuentra al corriente en el pago del impuesto predial hasta:
                </p>

                <p class="parrafo">
                    el sexto bimestre del {{ now()->format('Y') }} segun recibo: {{ $predio->pagos()->first()->año }}-{{ $predio->pagos()->first()->folio }}-{{ $predio->pagos()->first()->usuario }} con fecha {{ $predio->pagos()->first()->created_at }}
                </p>

            @endif

        @endif

        <div>

            <table style="margin-top: 40px">

                <tbody>
                    <tr>

                        <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                            <p style="text-transform: uppercase;"></p>
                            <p style="border-top: gray solid 1px; text-align: center">SEllo de la oficina</p>

                        </td>

                        <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                            <p style="text-transform: uppercase;">{{ $tesorero }}</p>
                            <p style="border-top: gray solid 1px; text-align: center">Tesorero municipal</p>

                        </td>

                    </tr>
                </tbody>

            </table>

        </div>

        <div class="informacion">

            <p class="parrafo">
                el pago de los derechos generados por la expedición de la presente, fueron enterados a la tesorería municipal.
            </p>

        </div>

    </main>

</body>
</html>
