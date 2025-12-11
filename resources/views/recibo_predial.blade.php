<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo predial</title>
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

            <p class="titulo">{{ $oficina->tipo }}</p>

            <p class="titulo">{{ $oficina->nombre }}</p>

            <p class="titulo">Comprobante de recibo de pago</p>

        </div>

        <p class="separador">Datos generales</p>

        <table style="margin-top: 10px">

            <tbody>
                <tr>
                    <td style="padding-right: 40px;">

                        <p><strong>Tipo de comprobante:</strong> Recibo</p>
                        <p><strong>Folio:</strong> {{ $pago->año }}-{{ $pago->folio }}-{{ $pago->usuario }}</p>
                        <p><strong>Fecha y hora de emisión:</strong> {{ $pago->created_at }}</p>
                        <p><strong>Método de pago:</strong> {{ $pago->tipo }}</p>
                        <p><strong>Forma de pago:</strong> {{ $pago->medio_pago }}</p>

                    </td>
                    <td style="padding-right: 40px;">

                        <p><strong>Contribuyente:</strong> {{ $predio->primerPropietario() }}</p>
                        <p><strong>Cuenta predial:</strong> {{ $predio->cuentaPredial() }}</p>
                        <p><strong>Valor catastral:</strong> ${{ number_format($predio->valor_catastral, 2) }}</p>
                        <p><strong>Tasa:</strong> {{ $tasa }} %</p>
                        <p><strong>COncepto:</strong> Impuesto predial @if($predio->tipo_predio == 1) urbano @else rustico @endif</p>

                    </td>
                </tr>
            </tbody>

        </table>

        <p class="separador">UBICACIÓN DEL INMUEBLE</p>

        <p class="parrafo">

            @if ($predio->codigo_postal)
                <strong>CÓDIGO POSTAL:</strong> {{ $predio->codigo_postal }};
            @endif

            @if ($predio->tipo_asentamiento)
                <strong>TIPO DE ASENTAMIENTO:</strong> {{ $predio->tipo_asentamiento }};
            @endif

            @if ($predio->nombre_asentamiento)
                <strong>NOMBRE DEL ASENTAMIENTO:</strong> {{ $predio->nombre_asentamiento }};
            @endif

            @if ($predio->municipio)
                <strong>MUNICIPIO:</strong> {{ $predio->municipio }};
            @endif

            @if ($predio->localidad)
                <strong>LOCALIDAD:</strong> {{ $predio->localidad }};
            @endif

            @if ($predio->tipo_vialidad)
                <strong>TIPO DE VIALIDAD:</strong> {{ $predio->tipo_vialidad }};
            @endif

            @if ($predio->nombre_vialidad)
                <strong>NOMBRE DE LA VIALIDAD:</strong> {{ $predio->nombre_vialidad }};
            @endif

            @if ($predio->numero_exterior)
                <strong>NÚMERO EXTERIOR:</strong> {{ $predio->numero_exterior }};
            @endif

            @if ($predio->numero_interior)
                <strong>NÚMERO INTERIOR:</strong> {{ $predio->numero_interior }};
            @endif

            @if ($predio->nombre_edificio)
                <strong>EDIFICIO:</strong> {{ $predio->nombre_edificio }};
            @endif

            @if ($predio->clave_edificio)
                <strong>clave del edificio:</strong> {{ $predio->clave_edificio }};
            @endif

            @if ($predio->departamento_edificio)
                <strong>DEPARTAMENTO:</strong> {{ $predio->departamento_edificio }};
            @endif

            @if ($predio->manzana)
                <strong>MANZANA:</strong> {{ $predio->manzana }};
            @endif

            @if ($predio->numero_exterior_2)
                <strong>número exterior 2:</strong> {{ $predio->numero_exterior_2 }};
            @endif

            @if ($predio->numero_adicional)
                <strong>número adicional:</strong> {{ $predio->numero_adicional }};
            @endif

            @if ($predio->numero_adicional_2)
                <strong>número adicional 2:</strong> {{ $predio->numero_adicional_2 }};
            @endif

            @if ($predio->lote_fraccionador)
                <strong>lote del fraccionador:</strong> {{ $predio->lote_fraccionador }};
            @endif

            @if ($predio->manzana_fraccionador)
                <strong>manzana del fraccionador:</strong> {{ $predio->manzana_fraccionador }};
            @endif

            @if ($predio->etapa_fraccionador)
                <strong>etapa del fraccionador:</strong> {{ $predio->etapa_fraccionador }};
            @endif

            @if ($predio->ubicacion_en_manzana)
                <strong>ubicación en manzana:</strong> {{ $predio->ubicacion_en_manzana }};
            @endif

        </p>

        <p class="separador">Domicilio para recibir notificaciones</p>

        <p class="parrafo">

            {{ $predio->primerPropietarioDomicilio() }}

        </p>

        <p class="separador">
            Periodo de pago:
            @if(count($rezago_años))

                del {{ $rezago_años[0] }} al {{ end($rezago_años) }}

            @endif

            {{ $cuota }} anual {{ now()->format('Y') }}
        </p>

        <table>
            <thead>
                <tr>
                <th>Descripción</th>
                <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>impuesto predial</td>
                <td>${{ number_format($cuenta_corriente_impuesto, 2) }}</td>
                </tr>
                <tr>
                <td>impuesto predial (rezago)</td>
                <td>${{ number_format($rezago_impuesto, 2) }}</td>
                </tr>
                <tr>
                <td>recargos de impuesto predial</td>
                <td>${{ number_format($cuenta_corriente_recargos, 2) }}</td>
                </tr>
                <tr>
                <td>multa del impuesto predial</td>
                <td>${{ number_format($cuenta_corriente_multas, 2) }}</td>
                </tr>
                <tr>
                <td>honorarios y gastos de ejecución</td>
                <td>${{ number_format($cuenta_corriente_reqerimientos, 2) }}</td>
                </tr>
                <tr>
                <td>federación de la pequeña propiedad</td>
                <td>$0</td>
                </tr>
                <tr>
                <td>Descuento</td>
                <td>${{ number_format($descuentos) }}</td>
                </tr>
                <tr>
                <td>Total</td>
                <td>${{ number_format($total, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <p style="text-align: center;">({{ $total_letra }} pesos 0/100 m.n)</p>

        <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline"></p>
        <p style="text-align: center;" >Sello</p>

        <p>Lo atendió: {{ $pago->creadoPor->name }}</p>
        <p>Nombre fiscal: {{ $oficina->nombre }}</p>
        <p>R.F.C.: {{ $oficina->nombre }}</p>
        <p>Domicilio fiscal: {{ $oficina->ubicacion }}</p>

        <p>Nota</p>
        <p>la determinación de los valores y procedimientos aritméticos que se realizaron para llegar a la conclusión del valor catastral del predio en referencia, se encuentran incluidos en el artículo 21 de la ley de hacienda municipal del estado de michoacán de ocampo</p>

    </main>

</body>
</html>
