<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-3 justify-center">

    <div>

        @if($actualizacion)

            <x-input-group for="accion" label="Origen del movimiento" :error="$errors->first('accion')" class="mb-2">

                <x-input-select id="accion" wire:model="accion" class="">

                    <option value="">Seleccione una opción</option>

                    @foreach ($acciones_actualizacion as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

        @else

            <x-input-group for="accion" label="Origen del movimiento" :error="$errors->first('accion')" class="mb-2">

                <x-input-select id="accion" wire:model="accion" class="">

                    <option value="">Seleccione una opción</option>

                    @foreach ($acciones_alta as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

        @endif

        <x-input-group for="observaciones" label="Descripción del movimiento" :error="$errors->first('observaciones')">

            <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones" placeholder="Se lo más especifico posible acerca del origen del movimiento"></textarea>

        </x-input-group>

    </div>

</div>

<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

    <div class="flex items-center justify-center">

        <x-input-group for="actualizacion" label="Actualización" :error="$errors->first('actualizacion')" class="flex gap-3 items-center">

            <x-checkbox wire:model.live="actualizacion" id="actualizacion"/>

        </x-input-group>

    </div>

    <div class="flex-auto ">

        <div class="">

            <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                </div>

                <div class="space-y-1">

                    <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

                    <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio.oficina') border-1 border-red-500 @enderror" wire:model.blur="predio.oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                    <input title="Tipo de predio" placeholder="Tipo" type="number" min="1" max="2" class="bg-white rounded text-xs w-20 @error('predio.tipo_predio') border-1 border-red-500 @enderror" wire:model="predio.tipo_predio">

                    <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.blur="predio.numero_registro">

                </div>

            </div>

            <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                 <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                </div>

                <div class="space-y-1">

                    <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                    <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('predio.region_catastral') border-1 border-red-500 @enderror" wire:model="predio.region_catastral" readonly>

                    <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('predio.municipio') border-1 border-red-500 @enderror" wire:model="predio.municipio" readonly>

                    <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('predio.zona_catastral') border-1 border-red-500 @enderror" wire:model="predio.zona_catastral" readonly>

                    <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

                    <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('predio.sector') border-1 border-red-500 @enderror" wire:model="predio.sector">

                    <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('predio.manzana') border-1 border-red-500 @enderror" wire:model="predio.manzana">

                    <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20 @error('predio.predio') border-1 border-red-500 @enderror" wire:model.blur="predio.predio">

                    <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('predio.edificio') border-1 border-red-500 @enderror" wire:model="predio.edificio">

                    <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('predio.departamento') border-1 border-red-500 @enderror" wire:model="predio.departamento">

                </div>

            </div>

        </div>

        @if($actualizacion)

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

                @if($predio->id)

                    <button
                        wire:click="$toggle('modalIndexar')"
                        wire:loading.attr="disabled"
                        wire:target="$toggle('modalIndexar')"
                        type="button"
                        class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-gray-700 focus:outline-none flex items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                        <img wire:loading wire:target="$toggle('modalIndexar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Indexar

                    </button>

                    <button
                        wire:click="$toggle('modalBaja')"
                        wire:loading.attr="disabled"
                        wire:target="$toggle('modalBaja')"
                        type="button"
                        class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-red-700 focus:outline-none flex items-center justify-center focus:outline-red-400 focus:outline-offset-2">

                        <img wire:loading wire:target="$toggle('modalBaja')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Dar de baja

                    </button>

                @endif

            </div>

        @endif

    </div>

</div>

@if(!$actualizacion)

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <h4 class="text-lg mb-5 text-center">Documento de entrada</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 items-start">

            <div class="flex-auto">

                <div>

                    <Label class="text-sm">Tipo de documento</Label>
                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full" wire:model.live="predio.documento_entrada">
                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($documentos as $item)

                            <option value="{{ $item }}" selected>{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

                <div>

                    @error('predio.documento_entrada') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto">

                <div>

                    <Label class="text-sm">Declarante</Label>
                </div>

                <div>

                    @if(in_array($predio->documento_entrada, ['ESCRITURA PÚBLICA', 'ESCRITURA PRIVADA']))

                        <select class="bg-white rounded text-xs w-full" wire:model="predio.declarante">
                            <option value="" selected>Seleccione una opción</option>

                            @foreach ($notarias as $notaria)

                                <option value="{{ $notaria->numero . ' ' . $notaria->notario }}" selected>{{ $notaria->numero . ' ' . $notaria->notario }}</option>

                            @endforeach

                        </select>

                    @else

                        <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.declarante">

                    @endif

                </div>

                <div>

                    @error('predio.declarante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto">

                <div class="">

                    <label class="text-sm " >{{ $label }}</label>

                </div>

                <div>

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.documento_numero">

                </div>

                <div>

                    @error('predio.documento_numero') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Fecha de efectos</Label>
                </div>

                <div>

                    <input type="date" class="bg-white rounded text-xs w-full" wire:model="predio.fecha_efectos">

                </div>

                <div>

                    @error('predio.fecha_efectos') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </div>

    </div>

@endif

<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

    <h4 class="text-lg mb-5 text-center">Ubicación del predio</h4>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 items-start">

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Código postal</label>

            </div>

            <div>

                <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.codigo_postal">

            </div>

            <div>

                @error('predio.codigo_postal') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto">

            <div>

                <Label class="text-sm">Tipo de asentamiento</Label>
            </div>

            <div>


                <select class="bg-white rounded text-xs w-full" wire:model="predio.tipo_asentamiento">
                    <option value="" selected>Seleccione una opción</option>

                    @foreach ($tipoAsentamientos as $item)

                        <option value="{{ $item }}" selected>{{ $item }}</option>

                    @endforeach

                </select>


            </div>

            <div>

                @error('predio.tipo_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto">

            <div class="">

                <label class="text-sm " >Nombre del asentamiento</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_asentamiento">

            </div>

            <div>

                @error('predio.nombre_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <Label class="text-sm">Tipo de vialidad</Label>
            </div>

            <div>

                <select class="bg-white rounded text-xs w-full" wire:model="predio.tipo_vialidad">
                    <option value="" selected>Seleccione una opción</option>

                    @foreach ($tipoVialidades as $item)

                        <option value="{{ $item }}" selected>{{ $item }}</option>

                    @endforeach

                </select>

            </div>

            <div>

                @error('predio.tipo_vialidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Nombre de la vialidad</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_vialidad">

            </div>

            <div>

                @error('predio.nombre_vialidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Número exterior</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_exterior">

            </div>

            <div>

                @error('predio.numero_exterior') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Número exterior 2</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_exterior_2">

            </div>

            <div>

                @error('predio.numero_exterior_2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Número interior</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_interior">

            </div>

            <div>

                @error('predio.numero_interior') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Número adicional</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_adicional">

            </div>

            <div>

                @error('predio.numero_adicional') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Número adicional 2</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_adicional_2">

            </div>

            <div>

                @error('predio.numero_adicional_2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Lote del fraccionador</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.lote_fraccionador">

            </div>

            <div>

                @error('predio.lote_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Manzana del fraccionador</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.manzana_fraccionador">

            </div>

            <div>

                @error('predio.manzana_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm" >Etapa o zona del fraccionador</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.etapa_fraccionador">

            </div>

            <div>

                @error('predio.etapa_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm">Nombre del Edificio</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_edificio">

            </div>

            <div>

                @error('predio.nombre_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm">Clave del edificio</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.clave_edificio">

            </div>

            <div>

                @error('predio.clave_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <label class="text-sm">Departamento</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.departamento_edificio">

            </div>

            <div>

                @error('predio.departamento_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="flex-auto col-span-2">

            <div>

                <label class="text-sm">Predio Rústico Denominado ó Antecedente</label>

            </div>

            <div>

                <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_predio">

            </div>

            <div>

                @error('predio.nombre_predio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

</div>

<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

    <h4 class="text-lg mb-5 text-center">Coordenadas geográficas</h4>

    <div class="flex-auto ">

        <div class="">

            <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">UTM</Label>

                </div>

                <div class="space-y-1">

                    <input placeholder="X" type="text" class="bg-white rounded text-xs w-40 @error('predio.xutm') border-red-500 @enderror" wire:model.blur="predio.xutm">

                    <input placeholder="Y" type="text" class="bg-white rounded text-xs w-40 @error('predio.yutm') border-red-500 @enderror" wire:model.blur="predio.yutm">

                    <select class="bg-white rounded text-xs" wire:model.blur="predio.zutm">

                        <option value="" selected>Z</option>
                        <option value="13" selected>13</option>
                        <option value="14" selected>14</option>

                    </select>

                    <input placeholder="Norte" type="text" class="bg-white rounded text-xs w-40" readonly>

                </div>

            </div>

        </div>

        <div class="">

            <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">GEO</Label>

                </div>

                <div class="space-y-1">

                    <input placeholder="Lat" type="number" class="bg-white rounded text-xs w-40 @error('predio.lat') border-red-500 @enderror" wire:model.blur="predio.lat">

                    <input placeholder="Lon" type="number" class="bg-white rounded text-xs w-40 @error('predio.lon') border-red-500 @enderror" wire:model.blur="predio.lon">

                </div>

                <button
                    wire:click="resetearCoordenadas"
                    wire:loading.attr="disabled"
                    wire:target="resetearCoordenadas"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>

                </button>

            </div>

        </div>

    </div>

</div>

<div class="bg-white rounded-lg p-3 flex gap-3 mb-3 shadow-lg">

    <x-input-group for="predio.superficie_total_terreno" label="Sup. de terreno (mts.)" :error="$errors->first('predio.superficie_total_terreno')" class="w-full">

        <x-input-text type="number" id="predio.superficie_total_terreno" wire:model="predio.superficie_total_terreno" />

    </x-input-group>

    <x-input-group for="predio.superficie_total_construccion" label="Sup. construcción {{ $predio->tipo_predio == 2 ? '(has.)' : '(mts.)' }}" :error="$errors->first('predio.superficie_total_construccion')" class="w-full">

        <x-input-text type="number" id="predio.superficie_total_construccion" wire:model="predio.superficie_total_construccion" />

    </x-input-group>

    <x-input-group for="predio.superficie_notarial" label="Sup. notarial {{ $predio->tipo_predio == 2 ? '(has.)' : '(mts.)' }}" :error="$errors->first('predio.superficie_notarial')" class="w-full">

        <x-input-text type="number" id="predio.superficie_notarial" wire:model="predio.superficie_notarial" />

    </x-input-group>

    <x-input-group for="predio.superficie_judicial" label="Sup. judicial {{ $predio->tipo_predio == 2 ? '(has.)' : '(mts.)' }}" :error="$errors->first('predio.superficie_judicial')" class="w-full">

        <x-input-text type="number" id="predio.superficie_judicial" wire:model="predio.superficie_judicial" />

    </x-input-group>

    <x-input-group for="predio.valor_catastral" label="Valor catastral" :error="$errors->first('predio.valor_catastral')" class="w-full">

        <x-input-text type="number" id="predio.valor_catastral" wire:model="predio.valor_catastral" />

    </x-input-group>

</div>

<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

    <div class=" mx-auto lg:w-1/2">

        <div>

            <h4 class="text-lg mb-1 text-center">Observaciones</h4>

        </div>

        <div>

            <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="predio.observaciones" placeholder=""></textarea>

        </div>

        <div>

            @error('predio.observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

        </div>

    </div>

</div>

@if(count($errors) > 0)

    <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

        <ul class="flex gap-2 felx flex-wrap list-disc ml-5">
        @foreach ($errors->all() as $error)

            <li class="text-red-500 text-xs md:text-sm ml-5">
                {{ $error }}
            </li>

        @endforeach

    </ul>

    </div>

@endif

<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end">

    @if($actualizacion)

        <x-button-green
            wire:click="actualizar"
            wire:loading.attr="disabled"
            wire:target="actualizar">

            <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Actualizar

        </x-button-green>

    @else

        <x-button-green
            wire:click="crear"
            wire:loading.attr="disabled"
            wire:target="crear">

            <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Guardar

        </x-button-green>

    @endif

</div>
