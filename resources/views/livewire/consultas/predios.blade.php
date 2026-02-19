<div class="">

    <div class="mb-2 lg:mb-5">

        <x-header>Predios</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <input type="number" wire:model.live.debounce.500ms="filters.localidad" placeholder="Localidad" class="bg-white rounded-full text-sm">

            @if(auth()->user()->hasRole('Administrador'))

                <input type="number" wire:model.live.debounce.500ms="filters.oficina" placeholder="Oficina" class="bg-white rounded-full text-sm">

            @endif

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.tipo">

                <option value="" selected>Tipo de predio</option>
                <option value="1">1</option>
                <option value="2">2</option>

            </select>

            <input type="number" wire:model.live.debounce.500ms="filters.registro" placeholder="Número de registro" class="bg-white rounded-full text-sm">

            <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>

            </select>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('localidad')" :direction="$sort === 'localidad' ? $direction : null" >Localidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina')" :direction="$sort === 'oficina' ? $direction : null" >Oficina</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo_predio')" :direction="$sort === 'tipo_predio' ? $direction : null" >Tipo de predio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('numero_registro')" :direction="$sort === 'numero_registro' ? $direction : null" >Número de registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($predios as $predio)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $predio->id }}">

                        <x-table.cell title="Estado">

                            <span class="bg-{{ $predio->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($predio->status) }}</span>

                        </x-table.cell>

                        <x-table.cell title="Localidad">

                            {{ $predio->localidad }}

                        </x-table.cell>

                        <x-table.cell title="Oficina">

                            {{ $predio->oficina }}

                        </x-table.cell>

                        <x-table.cell title="Tipo de predio">

                            {{ $predio->tipo_predio }}

                        </x-table.cell>

                        <x-table.cell title="Número de registro">

                            {{ $predio->numero_registro }}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            {{ $predio->created_at }}

                        </x-table.cell>

                        <x-table.cell title="Actualizado">

                            <span class="font-semibold">@if($predio->actualizadoPor != null)Actualizado por: {{$predio->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $predio->updated_at }}

                        </x-table.cell>

                        <x-table.cell title="Acciones">

                            <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    <a
                                        href="{{ route('ver_predio', $predio) }}"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver predio
                                    </a>

                                    <a
                                        href="{{ route('cobro_predial', $predio) }}"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Cobrar predial
                                    </a>

                                    <a
                                        href="{{ route('predio_detalle', $predio) }}"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver detalles
                                    </a>

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

                        {{ $predios->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    {{-- <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">
            Bloqueo
        </x-slot>

        <x-slot name="content">

            @if($this->modelo_editar->bloqueadoActivo())

                <div class="rounded-lg bg-gray-100 p-2 mb-3">

                    <p>El predio se encuentra bloqueado por el siguiente motivo:</p>

                    <p>{{ $this->modelo_editar->bloqueos->where('estado', 'activo')->first()->observaciones }}</p>

                </div>

            @endif

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full">

                <textarea class="bg-white rounded w-full" rows="5" wire:model="observaciones" placeholder="Menciona el oficio mediante el cual se solicita el bloqueo o desbloqueo"></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modal')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="bloquear"
                wire:loading.attr="disabled"
                wire:target="bloquear"
            >
                @if($this->modelo_editar->bloqueadoActivo())Desbloquear @else Bloquear @endif
            </x-danger-button>

        </x-slot>

    </x-dialog-modal> --}}

</div>
