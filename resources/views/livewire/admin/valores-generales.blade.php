<div class="">

    <div class="mb-6">

        <x-header>Valores generales</x-header>

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

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                    <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar nuevo valor

                </button>

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('ejercicio_fiscal')" :direction="$sort === 'ejercicio_fiscal' ? $direction : null" >Ejercicio fiscal</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('valor_catastral_minimo_urbanos')" :direction="$sort === 'valor_catastral_minimo_urbanos' ? $direction : null" >Minimo urbano</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('valor_catastral_minimo_rusticos')" :direction="$sort === 'valor_catastral_minimo_rusticos' ? $direction : null" >Minimo rustico</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->valores as $valor)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $valor->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Ejercicio fiscal</span>

                            {{ $valor->ejercicio_fiscal }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Minimo urbano</span>

                            ${{ number_format($valor->valor_catastral_minimo_urbanos, 2) }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Minimo rustico</span>

                            ${{ number_format($valor->valor_catastral_minimo_rusticos, 2) }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($valor->creadoPor != null)Registrado por: {{$valor->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $valor->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($valor->actualizadoPor != null)Actualizado por: {{$valor->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $valor->updated_at }}

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

                                    @can('Editar valor')

                                        <button
                                            wire:click="abrirModalEditar({{ $valor->id }})"
                                            wire:target="abrirModalEditar({{ $valor->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Editar
                                        </button>

                                    @endcan

                                    @can('Borrar valor')

                                        <button
                                            wire:click="abrirModalBorrar({{ $valor->id }})"
                                            wire:target="abrirModalBorrar({{ $valor->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Borrar
                                        </button>

                                    @endcan

                                </div>

                            </div>

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

                    <x-table.cell colspan="9" class="bg-gray-50">

                        {{ $this->valores->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal" maxWidth="sm">

        <x-slot name="title">

            @if($crear)
                Nuevo valor general
            @elseif($editar)
                Editar valor general
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.ejercicio_fiscal" label="Ejercicio fiscal" :error="$errors->first('modelo_editar.ejercicio_fiscal')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.ejercicio_fiscal" wire:model="modelo_editar.ejercicio_fiscal" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.valor_catastral_minimo_urbanos" label="Minimo urbanos" :error="$errors->first('modelo_editar.valor_catastral_minimo_urbanos')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.valor_catastral_minimo_urbanos" wire:model="modelo_editar.valor_catastral_minimo_urbanos" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.valor_catastral_minimo_rusticos" label="Minimo rusticos" :error="$errors->first('modelo_editar.valor_catastral_minimo_rusticos')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.valor_catastral_minimo_rusticos" wire:model="modelo_editar.valor_catastral_minimo_rusticos" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.inpc_enero" label="INCP Enero" :error="$errors->first('modelo_editar.inpc_enero')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_enero" wire:model="modelo_editar.inpc_enero" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.inpc_febrero" label="INCP Febrero" :error="$errors->first('modelo_editar.inpc_febrero')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_febrero" wire:model="modelo_editar.inpc_febrero" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.inpc_marzo" label="INCP Marzo" :error="$errors->first('modelo_editar.inpc_marzo')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_marzo" wire:model="modelo_editar.inpc_marzo" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.inpc_abril" label="INCP Abril" :error="$errors->first('modelo_editar.inpc_abril')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_abril" wire:model="modelo_editar.inpc_abril" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.inpc_mayo" label="INCP Mayo" :error="$errors->first('modelo_editar.inpc_mayo')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_mayo" wire:model="modelo_editar.inpc_mayo" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.inpc_junio" label="INCP Junio" :error="$errors->first('modelo_editar.inpc_junio')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_junio" wire:model="modelo_editar.inpc_junio" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.inpc_julio" label="INCP Julio" :error="$errors->first('modelo_editar.inpc_julio')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_julio" wire:model="modelo_editar.inpc_julio" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.inpc_agosto" label="INCP Agosto" :error="$errors->first('modelo_editar.inpc_agosto')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_agosto" wire:model="modelo_editar.inpc_agosto" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.inpc_septiembre" label="INCP Septiembre" :error="$errors->first('modelo_editar.inpc_septiembre')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_septiembre" wire:model="modelo_editar.inpc_septiembre" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.inpc_octubre" label="INCP Octubre" :error="$errors->first('modelo_editar.inpc_octubre')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_octubre" wire:model="modelo_editar.inpc_octubre" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.inpc_noviembre" label="INCP Noviembre" :error="$errors->first('modelo_editar.inpc_noviembre')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_noviembre" wire:model="modelo_editar.inpc_noviembre" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.inpc_diciembre" label="INCP Diciembre" :error="$errors->first('modelo_editar.inpc_diciembre')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.inpc_diciembre" wire:model="modelo_editar.inpc_diciembre" />

                    </x-input-group>

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
                    wire:target="resetearTodo">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model.live="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar valor
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar el valor? No sera posible recuperar la información.
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
