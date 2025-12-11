@extends('layouts.admin')

@section('content')

    <x-header>Predio</x-header>

    <x-h4>Datos generales</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuenta predial</strong>

                <p>{{ $predio->localidad }}-{{ $predio->oficina }}-{{ $predio->tipo_predio }}-{{ $predio->numero_registro }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clave catastral</strong>

                <p>{{ $predio->estado }}-{{ $predio->region_catastral }}-{{ $predio->municipio }}-{{ $predio->zona_catastral }}-{{ $predio->localidad }}-{{ $predio->sector }}-{{ $predio->manzana }}-{{ $predio->predio }}-{{ $predio->edificio }}-{{ $predio->departamento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Estado</strong>

                <p>{{ $predio->status }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Folio real</strong>

                <p>{{ $predio->folio_real }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Declarante</strong>

                <p>{{ $predio->declarante }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>CURT</strong>

                <p>{{ $predio->curt }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de efectos</strong>

                <p>{{ $predio->fecha_efectos }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie notarial</strong>

                <p>{{ number_format($predio->superficie_notarial, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie judicial</strong>

                <p>{{ number_format($predio->superficie_judicial, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie total de terreno</strong>

                <p>{{ number_format($predio->superficie_total_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor total de terreno</strong>

                <p>{{ number_format($predio->valor_total_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie total de construcción</strong>

                <p>{{ number_format($predio->superficie_total_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor total de construcción</strong>

                <p>{{ number_format($predio->valor_total_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor catastral</strong>

                <p>${{ number_format($predio->valor_catastral, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Uso del predio</strong>

                <p>Uso 1: {{ $predio->uso_1 }}</p>
                <p>Uso 2: {{ $predio->uso_2 }}</p>
                <p>Uso 3: {{ $predio->uso_3 }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Documento de entrada - Número de documento</strong>

                <p>{{ $predio->documento_entrada }} - {{ $predio->documento_numero }}</p>

            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-5 rounded-lg bg-gray-100 py-1 px-2">

                <strong>Observaciones</strong>

                <p>{{ $predio->observaciones }}</p>

            </div>

        </div>

    </div>

    <x-h4>Ubicación del predio</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de asentamiento</strong>

                <p>{{ $predio->tipo_asentamiento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Nombre del asentamiento</strong>

                <p>{{ $predio->nombre_asentamiento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de vialidad</strong>

                <p>{{ $predio->tipo_vialidad }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Nombre de la vialidad</strong>

                <p>{{ $predio->nombre_vialidad }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número exterior</strong>

                <p>{{ $predio->numero_exterior }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número exterior 2</strong>

                <p>{{ $predio->numero_exterior_2 }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número interior</strong>

                <p>{{ $predio->numero_interior }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número adicional</strong>

                <p>{{ $predio->numero_adicional }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número adicional 2</strong>

                <p>{{ $predio->numero_adicional_2 }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Código postal</strong>

                <p>{{ $predio->codigo_postal }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Lote del fraccionador</strong>

                <p>{{ $predio->lote_fraccionador }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Manzana del fraccionador</strong>

                <p>{{ $predio->manzana_fraccionador }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Etapa o zona del fraccionador</strong>

                <p>{{ $predio->etapa_fraccionador }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Nombre del Edificio</strong>

                <p>{{ $predio->nombre_edificio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clave del edificio</strong>

                <p>{{ $predio->clave_edificio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Departamento</strong>

                <p>{{ $predio->departamento_edificio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Predio Rústico Denominado ó Antecedente</strong>

                <p>{{ $predio->nombre_predio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Ubicación en manzana</strong>

                <p>{{ $predio->ubicacion_en_manzana }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Coordenadas geográficas UTM</strong>

                <p>X: {{ $predio->xutm }}</p>
                <p>Y: {{ $predio->yutm }}</p>
                <p>Z: {{ $predio->zutm }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Coordenadas geográficas GEO</strong>

                <p>Lat: {{ $predio->lat }}</p>
                <p>Lon: {{ $predio->lon }}</p>
                <div class="flex items-center gap-2">

                    <a href="{{ 'http://mapa.catastro.michoacan.gob.mx:8080/index.html?pzoom=20&plat=' . $predio->lat . '&plon=' . $predio->lon }}" title="SIG" target="_blank">
                        <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="SIG">
                    </a>

                    <a href="{{ 'https://www.google.com/maps/?q=' . $predio->lat . ',' . $predio->lon . '&z=5&t=k' }}" title="Google" target="_blank">

                        <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="Google">

                    </a>

                    <a href="" title="Cartografía" target="_blank">
                        <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="Cartografía">
                    </a>

                </div>

            </div>

        </div>

    </div>

    <x-h4>Colindancias ({{ $predio->colindancias->count() }})</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 overflow-x-auto">

        <table class="table-auto lg:table-fixed w-full">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider">

                    <th class="px-2">Viento</th>
                    <th class="px-2">Longitud(mts.)</th>
                    <th class="px-2">Descripción</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->colindancias as $colindancia)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full">{{ $colindancia->viento }}</td>
                        <td class=" px-2 w-full">{{ $colindancia->longitud }}</td>
                        <td class=" px-2 w-full">{{ $colindancia->descripcion }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <x-h4>Propietarios ({{ $predio->propietarios->count() }})</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5  overflow-x-auto table-fixed text-sm">

        <table class="table-auto lg:table-fixed w-full">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Tipo de persona</th>
                    <th class="px-2">Nombre / Razón social</th>
                    <th class="px-2">Porcentaje de propiedad</th>
                    <th class="px-2">Porcentaje de nuda</th>
                    <th class="px-2">Porcentaje de usufructo</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->propietarios->sortBy('persona.nombre') as $propietario)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $propietario->persona->tipo }}</td>
                        <td class=" px-2 w-full ">{{ $propietario->persona->nombre }} {{ $propietario->persona->ap_paterno }} {{ $propietario->persona->ap_materno }} {{ $propietario->persona->razon_social }}</td>
                        <td class=" px-2 w-full ">{{ $propietario->porcentaje_propiedad }}%</td>
                        <td class=" px-2 w-full ">{{ $propietario->porcentaje_nuda }}%</td>
                        <td class=" px-2 w-full ">{{ $propietario->porcentaje_usufructo }}%</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@endsection