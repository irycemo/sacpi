<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recibo ISAI</title>
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
            <p>www.irycem.michoacan.gob.mx</p>
        </div>

    </footer>

    <main>

        <div>

            <p class="titulo">sistema para la administración de las contribuciones sobre la propiedad inmobiliaria</p>

            <p class="titulo">h. ayuntamiento constitucional de {{ $oficina->nombre }}</p>

            <p class="titulo">RECIBO DE PAGO DE ISAI</p>

        </div>

        <div class="informacion" >

            <p><strong>Tipo de comprobante: </strong> Recibo</p>
            <p><strong>Folio del recibo: </strong> {{ $pago->año }}-{{ $pago->folio }}-{{ $pago->usuario }}</p>
            <p><strong>Fecha y hora de emisión: </strong> {{ $pago->created_at }}</p>
            <p><strong>Metodo de pago: </strong> EFECTIVO</p>
            <p><strong>Forma de pago: </strong> UNA SOLA EXHIBICIÓN</p>

        </div>

        <p class="separador"><strong>DATOS DEL PREDIO</strong></p>

        <div class="informacion" >

            <p><strong>Nombre del Contribuyente: </strong> {{ $contribuyente }}</p>
            <p><strong>Cuenta predial: </strong> {{ $cuenta_predial }}</p>
            <p><strong>Clave Catastral: </strong> {{ $clave_catastral }}</p>
            <p><strong>Valor Catastral: </strong> $ {{ number_format($valor_catastral,2) }}</p>
            <p><strong>Concepto de pago: </strong> IMPUESTO SOBRE ADQUISICIÓN DE INMUEBLES (ISAI)</p>
            <p><strong>UBICACIÓN DEL PREDIO: </strong> {{ $ubicacion_predio }}</p>
            <p><strong>DOMICILIO PARA RECIBIR NOTIFICACIONES: </strong> {{ $notificacion }}</p>

        </div>

        <p class="separador"><strong>DETALLE DEL PAGO</strong></p>

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
                <td>${{ number_format($impuesto, 2) }}</td>
                </tr>
                <tr>
                <td>actualización</td>
                <td>${{ number_format($actualizacion, 2) }}</td>
                </tr>
                <tr>
                <td>multas</td>
                <td>${{ number_format($multas, 2) }}</td>
                </tr>
                <tr>
                <td>recargos</td>
                <td>${{ number_format($recargos, 2) }}</td>
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
