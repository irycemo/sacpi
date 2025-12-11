<div class="">

    <div class="mb-6">

        <x-header>Descuentos</x-header>

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
                    Agregar nuevo descuento

                </button>

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('nombre')" :direction="$sort === 'nombre' ? $direction : null" >Nombre</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('fecha_inicial')" :direction="$sort === 'fecha_inicial' ? $direction : null" >Fecha inicial</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('fecha_final')" :direction="$sort === 'fecha_final' ? $direction : null" >Fecha final</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('porcentaje')" :direction="$sort === 'porcentaje' ? $direction : null" >Porcentaje</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->descuentos as $descuento)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $descuento->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Nombre</span>

                            {{ $descuento->nombre }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Fecha inicial</span>

                            {{ $descuento->fecha_inicial }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Fecha final</span>

                            {{ $descuento->fecha_final }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Porcentaje</span>

                            {{ $descuento->porcentaje }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Registrado</span>

                            {{ $descuento->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            {{ $descuento->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex justify-center lg:justify-start gap-2">

                                @can('Editar descuento')

                                    <x-button-blue
                                        wire:click="abrirModalEditar({{$descuento->id}})"
                                        wire:loading.attr="disabled"
                                        wire:target="abiriModalEditar({{$descuento->id}})"
                                    >


                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>

                                        <p>Editar</p>

                                    </x-button-blue>

                                @endcan


                                @can('Borrar descuento')

                                    <x-button-red
                                        wire:click="abrirModalBorrar({{$descuento->id}})"
                                        wire:loading.attr="disabled"
                                        wire:target="abrirModalBorrar({{$descuento->id}})"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-3">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>

                                        <p>Eliminar</p>

                                    </x-button-red>

                                @endcan

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

                        {{ $this->descuentos->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal" maxWidth="sm">

        <x-slot name="title">

            @if($crear)
                Nuevo descuento
            @elseif($editar)
                Editar descuento
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="space-y-3">

                <x-input-group for="modelo_editar.nombre" label="Nombre" :error="$errors->first('modelo_editar.nombre')" class="w-full">

                    <x-input-text type="number" id="modelo_editar.nombre" wire:model="modelo_editar.nombre" />

                </x-input-group>

                <x-input-group for="modelo_editar.fecha_inicial" label="Fecha inicial" :error="$errors->first('modelo_editar.fecha_inicial')" class="w-full">

                    <x-input-text type="date" id="modelo_editar.fecha_inicial" wire:model="modelo_editar.fecha_inicial" />

                </x-input-group>

                <x-input-group for="modelo_editar.fecha_final" label="Fecha final" :error="$errors->first('modelo_editar.fecha_final')" class="w-full">

                    <x-input-text type="date" id="modelo_editar.fecha_final" wire:model="modelo_editar.fecha_final" />

                </x-input-group>

                <x-input-group for="modelo_editar.porcentaje" label="Porcentaje" :error="$errors->first('modelo_editar.porcentaje')" class="w-full">

                    <x-input-text type="number" id="modelo_editar.porcentaje" wire:model="modelo_editar.porcentaje" />

                </x-input-group>

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
            Eliminar descuento
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar el descuento? No sera posible recuperar la información.
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
