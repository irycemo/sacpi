<div>

    <x-header>Consulta del padrón</x-header>

    <div class="bg-white p-4 rounded-lg shadow-lg mb-10">

        <ul class="grid w-full mx-auto gap-6 md:grid-cols-3">

            <li>

                <input type="radio" id="clave" name="hosting" value="clave" class="hidden peer" wire:model.live="radio" >

                <label for="clave" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Buscar por cuenta predial o clave catastral</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

            <li>

                <input type="radio" id="propietario" name="hosting" value="propietario" class="hidden peer" wire:model.live="radio">

                <label for="propietario" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Buscar por propietario</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

            <li>

                <input type="radio" id="ubicacion" name="hosting" value="ubicacion" class="hidden peer" wire:model.live="radio">

                <label for="ubicacion" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Buscar por ubicación</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

        </ul>

    </div>

    <div id="inputs">

        @if($radio === 'clave')

            <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg" id="claves-div">

                <div class="flex-auto " >

                    <div class="">

                        <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                            <div class="text-left">

                                <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                            </div>

                            <div class="space-y-1">

                                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                                <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.blur="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                                <input title="Tipo de predio" placeholder="Tipo" type="number" min="1" max="2" class="bg-white rounded text-xs w-20 @error('tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo_predio">

                                <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('numero_registro') border-1 border-red-500 @enderror" wire:model="numero_registro">

                                <div class="inline-flex items-center">
                                    <span class="text-xs mr-2">+/- 10</span><x-checkbox wire:model="diez"></x-checkbox>
                                </div>

                            </div>

                        </div>

                        <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                            <div class="text-left">

                                <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                            </div>

                            <div class="space-y-1">

                                <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                                <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral" readonly>

                                <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio" readonly>

                                <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral">

                                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                                <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                                <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

                            </div>

                        </div>

                    </div>

                    <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                        <button
                            wire:click="buscarCuentaPredial"
                            wire:loading.attr="disabled"
                            wire:target="buscarCuentaPredial"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                            <img wire:loading wire:target="buscarCuentaPredial" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Consultar cuenta predial

                        </button>

                        <button
                            wire:click="buscarClaveCatastral"
                            wire:loading.attr="disabled"
                            wire:target="buscarClaveCatastral"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                            <img wire:loading wire:target="buscarClaveCatastral" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Consultar clave catastral

                        </button>

                    </div>

                </div>

            </div>

        @elseif($radio === 'propietario')

            <div class="mb-5 bg-white rounded-lg p-4 shadow-lg" id="propietarios-div">

                <div class="flex flex-col lg:flex-row gap-3 mb-5">

                    <x-input-group for="nombre" label="Nombre" :error="$errors->first('nombre')" class="w-full">

                        <x-input-text id="nombre" wire:model="nombre" />

                    </x-input-group>

                    <x-input-group for="ap_paterno" label="Apellido paterno" :error="$errors->first('ap_paterno')" class="w-full">

                        <x-input-text id="ap_paterno" wire:model="ap_paterno" />

                    </x-input-group>

                    <x-input-group for="ap_materno" label="Apellido materno" :error="$errors->first('ap_materno')" class="w-full">

                        <x-input-text id="ap_materno" wire:model="ap_materno" />

                    </x-input-group>

                    <x-input-group for="razon_social" label="Razón social" :error="$errors->first('razon_social')" class="w-full">

                        <x-input-text id="razon_social" wire:model="razon_social" />

                    </x-input-group>

                    <x-input-group for="rfc" label="RFC" :error="$errors->first('rfc')" class="w-full">

                        <x-input-text id="rfc" wire:model="rfc" />

                    </x-input-group>

                    <x-input-group for="curp" label="CURP" :error="$errors->first('curp')" class="w-full">

                        <x-input-text id="curp" wire:model="curp" />

                    </x-input-group>

                </div>

                <button
                    wire:click="buscarPorPropietario"
                    wire:loading.attr="disabled"
                    wire:target="buscarPorPropietario"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white mx-auto font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarPorPropietario" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Buscar

                </button>

            </div>

        @elseif($radio === 'ubicacion')

            <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg" id="ubicacion-div">

                <x-input-group for="ubicacion" label="Ubicación" :error="$errors->first('ubicacion')" class="w-full lg:w-1/2 mx-auto mb-5">

                    <x-input-text id="ubicacion" wire:model="ubicacion" placeholder="Ingresa el texto para buscar en todos los campos de ubicación del predio"/>

                </x-input-group>

                <button
                    wire:click="buscarPorUbicacion"
                    wire:loading.attr="disabled"
                    wire:target="buscarPorUbicacion"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white mx-auto font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarPorUbicacion" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Buscar

                </button>

            </div>

        @endif

    </div>

    <div id="toggle">

        @if($this->prediosLista->count() && $flag)

            <div class="flex justify-end mb-3">
                <x-button-blue
                        wire:click="$toggle('flag')"
                        wire:loading.attr="disabled"
                        wire:target="$toggle('flag')">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                    </span>
                </x-button-blue>
            </div>

        @endif

    </div>

    <div id="table-list">

        @if(!$flag)

            <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

                <x-table>

                    <x-slot name="head">

                        <x-table.heading >Cuenta predial</x-table.heading>
                        <x-table.heading >Clave catastral</x-table.heading>
                        <x-table.heading >Propietario</x-table.heading>
                        <x-table.heading >Asentamiento</x-table.heading>
                        <x-table.heading >Vialidad</x-table.heading>
                        <x-table.heading ># Exterior / # Interior</x-table.heading>
                        <x-table.heading ></x-table.heading>

                    </x-slot>

                    <x-slot name="body">

                        @forelse ($this->prediosLista as $item)

                            <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $item->id }}">

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                                    <span class="whitespace-nowrap">{{ $item->cuentaPredial() }}</span>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Clave catastral</span>

                                    <p class="mt-2"><span class="whitespace-nowrap">{{ $item->claveCatastral() }}</span></p>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Propietario</span>

                                    <p class="mt-2">{{ $item->primerPropietario() }}</p>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Asentamiento</span>

                                    <p class="mt-2">{{ $item->tipo_asentamiento . ', ' . $item->nombre_asentamiento }}</p>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Vialidad</span>

                                    <p class="mt-2">{{ $item->tipo_vialidad . ', ' . $item->nombre_vialidad }}</p>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl"># Exterior / # Interior</span>

                                    {{ $item->numero_exterior . ', ' , $item->numero_interior }}

                                </x-table.cell>

                                <x-table.cell>

                                    <x-button-green
                                        wire:click="verPredio({{ $item->id }})"
                                        wire:loading.attr="disabled">
                                        Ver
                                    </x-button-green>

                                </x-table.cell>

                            </x-table.row>

                        @empty

                            <x-table.row wire:key="row-empty">

                                <x-table.cell colspan="9">

                                    <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                        No hay resultados.

                                    </div>

                                </x-table.cell>

                            </x-table.row>

                        @endforelse

                    </x-slot>

                    <x-slot name="tfoot">

                        <x-table.row>

                            <x-table.cell colspan="13" class="bg-gray-50">

                                {{ $this->prediosLista->links() }}

                            </x-table.cell>

                        </x-table.row>

                    </x-slot>

                </x-table>

            </div>

        @endif

    </div>

    <div id="predio">

        @if($flag && $this->predio)

            <div wire:loading.class.delaylongest="opacity-50">

                <x-h4>Datos generales</x-h4>

                <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Cuenta predial</strong>

                            <p>{{ $this->predio->localidad }}-{{ $this->predio->oficina }}-{{ $this->predio->tipo_predio }}-{{ $this->predio->numero_registro }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Clave catastral</strong>

                            <p>{{ $this->predio->estado }}-{{ $this->predio->region_catastral }}-{{ $this->predio->municipio }}-{{ $this->predio->zona_catastral }}-{{ $this->predio->localidad }}-{{ $this->predio->sector }}-{{ $this->predio->manzana }}-{{ $this->predio->predio }}-{{ $this->predio->edificio }}-{{ $this->predio->departamento }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Estado</strong>

                            <p>{{ $this->predio->status }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Folio real</strong>

                            <p>{{ $this->predio->folio_real }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Declarante</strong>

                            <p>{{ $this->predio->declarante }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>CURT</strong>

                            <p>{{ $this->predio->curt }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Fecha de efectos</strong>

                            <p>{{ $this->predio->fecha_efectos }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Superficie notarial</strong>

                            <p>{{ number_format($this->predio->superficie_notarial, 2) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Superficie judicial</strong>

                            <p>{{ number_format($this->predio->superficie_judicial, 2) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Superficie total de terreno</strong>

                            <p>{{ number_format($this->predio->superficie_total_terreno, 2) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Valor total de terreno</strong>

                            <p>{{ number_format($this->predio->valor_total_terreno, 2) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Superficie total de construcción</strong>

                            <p>{{ number_format($this->predio->superficie_total_construccion, 2) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Valor total de construcción</strong>

                            <p>{{ number_format($this->predio->valor_total_construccion, 2) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Valor catastral</strong>

                            <p>${{ number_format($this->predio->valor_catastral, 2) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Uso del predio</strong>

                            <p>Uso 1: {{ $this->predio->uso_1 }}</p>
                            <p>Uso 2: {{ $this->predio->uso_2 }}</p>
                            <p>Uso 3: {{ $this->predio->uso_3 }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Documento de entrada - Número de documento</strong>

                            <p>{{ $this->predio->documento_entrada }} - {{ $this->predio->documento_numero }}</p>

                        </div>

                        <div class="col-span-1 sm:col-span-2 lg:col-span-5 rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Observaciones</strong>

                            <p>{{ $this->predio->observaciones }}</p>

                        </div>

                    </div>

                </div>

                <x-h4>Ubicación del predio</x-h4>

                <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Tipo de asentamiento</strong>

                            <p>{{ $this->predio->tipo_asentamiento }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Nombre del asentamiento</strong>

                            <p>{{ $this->predio->nombre_asentamiento }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Tipo de vialidad</strong>

                            <p>{{ $this->predio->tipo_vialidad }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Nombre de la vialidad</strong>

                            <p>{{ $this->predio->nombre_vialidad }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Número exterior</strong>

                            <p>{{ $this->predio->numero_exterior }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Número exterior 2</strong>

                            <p>{{ $this->predio->numero_exterior_2 }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Número interior</strong>

                            <p>{{ $this->predio->numero_interior }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Número adicional</strong>

                            <p>{{ $this->predio->numero_adicional }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Número adicional 2</strong>

                            <p>{{ $this->predio->numero_adicional_2 }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Código postal</strong>

                            <p>{{ $this->predio->codigo_postal }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Lote del fraccionador</strong>

                            <p>{{ $this->predio->lote_fraccionador }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Manzana del fraccionador</strong>

                            <p>{{ $this->predio->manzana_fraccionador }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Etapa o zona del fraccionador</strong>

                            <p>{{ $this->predio->etapa_fraccionador }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Nombre del Edificio</strong>

                            <p>{{ $this->predio->nombre_edificio }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Clave del edificio</strong>

                            <p>{{ $this->predio->clave_edificio }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Departamento</strong>

                            <p>{{ $this->predio->departamento_edificio }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Predio Rústico Denominado ó Antecedente</strong>

                            <p>{{ $this->predio->nombre_predio }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Ubicación en manzana</strong>

                            <p>{{ $this->predio->ubicacion_en_manzana }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Coordenadas UTM</strong>

                            <p>X: {{ $this->predio->xutm }}</p>
                            <p>Y: {{ $this->predio->yutm }}</p>
                            <p>Z: {{ $this->predio->zutm }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Coordenadas geográficas</strong>

                            <p>Lat: {{ $this->predio->lat }}</p>
                            <p>Lon: {{ $this->predio->lon }}</p>
                            <div class="flex items-center gap-2">

                                <a href="{{ 'http://mapa.catastro.michoacan.gob.mx:8080/index.html?pzoom=20&plat=' . $this->predio->lat . '&plon=' . $this->predio->lon }}" title="SIG" target="_blank">
                                    <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="SIG">
                                </a>

                                <a href="{{ 'https://www.google.com/maps/?q=' . $this->predio->lat . ',' . $this->predio->lon . '&z=5&t=k' }}" title="Google" target="_blank">

                                    <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="Google">

                                </a>

                                <a href="" title="Cartografía" target="_blank">
                                    <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="Cartografía">
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <x-h4>Colindancias ({{ $this->predio->colindancias->count() }})</x-h4>

                <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 overflow-x-auto">

                    <table class="table-auto lg:table-fixed w-full">

                        <thead class="border-b border-gray-300 ">

                            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                                <th class="px-2">Viento</th>
                                <th class="px-2">Longitud(mts.)</th>
                                <th class="px-2">Descripción</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($this->predio->colindancias as $colindancia)

                                <tr class="text-gray-500 text-sm leading-relaxed">
                                    <td class=" px-2 w-full whitespace-nowrap">{{ $colindancia->viento }}</td>
                                    <td class=" px-2 w-full whitespace-nowrap">{{ $colindancia->longitud }}</td>
                                    <td class=" px-2 w-full">{{ $colindancia->descripcion }}</td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <x-h4>Propietarios ({{ $this->predio->propietarios->count() }})</x-h4>

                <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 overflow-x-auto">

                    <table class="table-auto lg:table-fixed w-full">

                        <thead class="border-b border-gray-300 ">

                            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                                <th class="px-2">Nombre / Razón social</th>
                                <th class="px-2">Porcentaje de propiedad</th>
                                <th class="px-2">Porcentaje de nuda</th>
                                <th class="px-2">Porcentaje de usufructo</th>
                                <th class="px-2">Tipo de persona</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($this->predio->propietarios->sortBy('persona.nombre') as $propietario)

                                <tr class="text-gray-500 text-sm leading-relaxed">
                                    <td class=" px-2 w-full ">{{ $propietario->persona->nombre }} {{ $propietario->persona->ap_paterno }} {{ $propietario->persona->ap_materno }} {{ $propietario->persona->razon_social }}</td>
                                    <td class=" px-2 w-full ">{{ $propietario->porcentaje_propiedad }}%</td>
                                    <td class=" px-2 w-full ">{{ $propietario->porcentaje_nuda }}%</td>
                                    <td class=" px-2 w-full ">{{ $propietario->porcentaje_usufructo }}%</td>
                                    <td class=" px-2 w-full ">{{ $propietario->persona->tipo }}</td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <x-h4>Movimientos ({{ $this->predio->movimientos->count() }})</x-h4>

                <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 overflow-x-auto">

                    <table class="table-auto lg:table-fixed w-full">

                        <thead class="border-b border-gray-300 ">

                            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                                <th class="px-2">Movimiento</th>
                                <th class="px-2">Fecha</th>
                                <th class="px-2">Descripción</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($this->predio->movimientos as $movimiento)

                                <tr class="text-gray-500 text-sm leading-relaxed">
                                    <td class=" px-2 w-full ">{{ $movimiento->nombre }}</td>
                                    <td class=" px-2 w-full ">{{ $movimiento->fecha->format('d-m-Y') }}</td>
                                    <td class=" px-2 w-full ">{{ $movimiento->descripcion }}</td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        @endif

    </div>

</div>
