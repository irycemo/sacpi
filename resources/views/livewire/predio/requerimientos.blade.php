<div class=" text-center">

    <div class="bg-white rounded-lg shadow-xl p-4 w-full lg:w-1/2 mx-auto mb-5">

        <x-button wire:loading.attr="disabled" wire:click="generarRequerimiento">
            Generar requerimiento
        </x-button>

    </div>

    <div class="bg-white rounded-lg shadow-xl p-4 w-full lg:w-1/2 mx-auto">

        <x-table>

            <x-slot name="head">
                <x-table.heading >Folio</x-table.heading>
                <x-table.heading >Notificación</x-table.heading>
                <x-table.heading >Monto</x-table.heading>
                <x-table.heading >Registro</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>
            </x-slot>

            <x-slot name="body">

                @forelse ($predio->requerimientos as $requerimiento)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $requerimiento->id }}">
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>
                            <span class="whitespace-nowrap">{{ $requerimiento->año }}-{{ $requerimiento->folio }}-{{ $requerimiento->usuario }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Notificación</span>
                            <span class="whitespace-nowrap">{{ $requerimiento->fecha_notificacion_formateada ?? 'N/A' }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Monto</span>
                            <span class="whitespace-nowrap">${{ number_format($requerimiento->monto, 4) }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registro</span>
                            <span class="whitespace-nowrap">{{ $requerimiento->created_at }}</span>
                        </x-table.cell>
                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    @if(!$requerimiento->fecha_notificacion)

                                        <button
                                            wire:click="notificar({{ $requerimiento->id }})"
                                            wire:confirm="¿Esta seguro que desea notificar el requerimiento?"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Notificar
                                        </button>

                                    @endif

                                </div>

                            </div>

                        </x-table.cell>
                    </x-table.row>

                @empty

                    <x-table.row wire:key="row-empty">

                        <x-table.cell colspan="9">

                            <div class="flex justify-center">

                                <div class="text-center">

                                    <span class="text-base">El predio no tiene invitaciones.</span>

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">
                <x-table.row>

                </x-table.row>
            </x-slot>

        </x-table>

    </div>

</div>
