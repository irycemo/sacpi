<div class="">

    <div class="mb-6">

        <x-header>Oficinas</x-header>

        <div class="flex justify-between">

            <div>

                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

                <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

            @can('Crear oficina')

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                    <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar nueva oficina

                </button>

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

            @endcan

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('region')" :direction="$sort === 'region' ? $direction : null" >Región</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('municipio')" :direction="$sort === 'municipio' ? $direction : null" >Municipio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('nombre')" :direction="$sort === 'nombre' ? $direction : null" >Nombre</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina')" :direction="$sort === 'oficina' ? $direction : null" >Oficina</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('localidad')" :direction="$sort === 'localidad' ? $direction : null" >Localidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('titular')" :direction="$sort === 'titular' ? $direction : null" >Titular</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo')" :direction="$sort === 'tipo' ? $direction : null" >Tipo</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->oficinas as $oficina)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $oficina->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Región</span>

                            {{ $oficina->region }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Municipio</span>

                            {{ $oficina->municipio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Nombre</span>

                            <p class="mt-2">{{ $oficina->nombre }}</p>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Oficina</span>

                            {{ $oficina->oficina }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Localidad</span>

                            {{ $oficina->localidad }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Titular</span>

                            <p class="mt-2">{{ $oficina->titular }}</p>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Tipo</span>

                            {{ $oficina->tipo }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($oficina->creadoPor != null)Registrado por: {{$oficina->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $oficina->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($oficina->actualizadoPor != null)Actualizado por: {{$oficina->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $oficina->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    @can('Ver oficina')

                                        {{-- <a
                                            href="{{ route('ver_oficina', $oficina) }}"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Ver
                                        </a> --}}

                                    @endcan

                                    @can('Editar oficina')

                                        <button
                                            wire:click="abrirModalEditar({{ $oficina->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Editar
                                        </button>

                                    @endcan

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row wire:key="row-empty">

                        <x-table.cell colspan="12">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="12" class="bg-gray-50">

                        {{ $this->oficinas->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal">

        <x-slot name="title">

            @if($crear)
                Nueva Oficina
            @elseif($editar)
                Editar Oficina
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.region" label="Región" :error="$errors->first('modelo_editar.region')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.region" wire:model="modelo_editar.region" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.municipio" label="Municipio" :error="$errors->first('modelo_editar.municipio')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.municipio" wire:model="modelo_editar.municipio" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.oficina" label="Oficina" :error="$errors->first('modelo_editar.oficina')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.oficina" wire:model="modelo_editar.oficina" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.localidad" label="Localidad" :error="$errors->first('modelo_editar.localidad')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.localidad" wire:model="modelo_editar.localidad" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.tipo" label="Tipo" :error="$errors->first('modelo_editar.tipo')" class="w-full">

                        <x-input-select id="modelo_editar.tipo" wire:model="modelo_editar.tipo" class="w-full">

                            <option value="">Seleccione una opción</option>
                            <option value="RECEPTORIA">Receptoria</option>
                            <option value="ADMINISTRACIÓN">Administración</option>

                        </x-input-select>

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.nombre" label="Nombre" :error="$errors->first('modelo_editar.nombre')" class="w-full">

                        <x-input-text id="modelo_editar.nombre" wire:model="modelo_editar.nombre" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.titular" label="Titular" :error="$errors->first('modelo_editar.titular')" class="w-full">

                        <x-input-text id="modelo_editar.titular" wire:model="modelo_editar.titular" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.telefonos" label="Teléfonos" :error="$errors->first('modelo_editar.telefonos')" class="w-full">

                        <x-input-text id="modelo_editar.telefonos" wire:model="modelo_editar.telefonos" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.email" label="Correo" :error="$errors->first('modelo_editar.email')" class="w-full">

                        <x-input-text type="email" id="modelo_editar.email" wire:model="modelo_editar.email" />

                    </x-input-group>

                </div>


                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.valuador_municipal" label="Valuador municipal" :error="$errors->first('modelo_editar.valuador_municipal')" class="w-full">

                        <x-input-text id="modelo_editar.valuador_municipal" wire:model="modelo_editar.valuador_municipal" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.autoridad_municipal" label="Autoridad municipal" :error="$errors->first('modelo_editar.autoridad_municipal')" class="w-full">

                        <x-input-text id="modelo_editar.autoridad_municipal" wire:model="modelo_editar.autoridad_municipal" />

                    </x-input-group>

                </div>

                <div class="flex-auto ">

                    <x-input-group for="modelo_editar.ubicacion" label="Ubicación" :error="$errors->first('modelo_editar.ubicacion')" class="w-full">

                        <x-input-text wire:model="modelo_editar.ubicacion"></x-input-text>

                    </x-input-group>

                </div>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="sectorInicial" label="Sector inicial" :error="$errors->first('sectorInicial')" class="w-full">

                        <x-input-text type="number" id="sectorInicial" wire:model="sectorInicial" />

                    </x-input-group>

                    <x-input-group for="sectorFinal" label="Sector final" :error="$errors->first('sectorFinal')" class="w-full">

                        <x-input-text type="number" id="sectorFinal" wire:model="sectorFinal" />

                    </x-input-group>

                </div>

                @if($sectores)

                    <div>

                        <p>Sectores:</p>
                        <p>
                            @foreach ($sectores as $sector)

                                {{ $sector }},

                            @endforeach
                        </p>

                    </div>

                @endif

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex items-center gap-3">

                @if($crear)

                    <x-button-blue
                        wire:click="guardar"
                        wire:loading.attr="disabled"
                        wire:target="guardar">

                        <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Guardar
                    </x-button-blue>

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Actualizar
                    </x-button-blue>

                @endif

                <x-button-red
                    wire:click="resetearTodo"
                    wire:loading.attr="disabled"
                    wire:target="resetearTodo"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model.live="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar Oficina
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar la oficina? No sera posible recuperar la información.
        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
