<div class="">

    <div class="mb-6">

        <x-header>Avisos autorizados</x-header>

        <div class="flex gap-4 items-center ">

            <div class="flex gap-1">

                <select class="bg-white rounded-full text-sm" wire:model.live="año">

                    @foreach ($años as $año)

                        <option value="{{ $año }}">{{ $año }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500mse="folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500mse="usuario" placeholder="Usuario" class="bg-white rounded-full text-sm w-24">

            </div>

            <div class="flex gap-1">

                <input type="number" wire:model.live.debounce.500ms="localidad" placeholder="Localidad" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="oficina" placeholder="Oficina" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="tipo_predio" placeholder="T. Predio" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="numero_registro" placeholder="# Registro" class="bg-white rounded-full text-sm w-24">

            </div>

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

                <x-table.heading >Folio</x-table.heading>
                <x-table.heading >Cuenta predial</x-table.heading>
                <x-table.heading >Notaria</x-table.heading>
                <x-table.heading >Fecha de reducción</x-table.heading>
                <x-table.heading >ISAI</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($avisos as $aviso)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $aviso['folio'] }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            <span class="whitespace-nowrap">{{ $aviso['año'] }}-{{ $aviso['folio'] }}-{{ $aviso['usuario'] }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                            <span class="whitespace-nowrap">{{ $aviso['localidad'] }}-{{ $aviso['oficina'] }}-{{ $aviso['tipo_predio'] }}-{{ $aviso['numero_registro'] }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Notaria</span>

                            <span >{{ $aviso['notaria_numero'] }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de reducción</span>

                            <span >{{ $aviso['fecha_reduccion'] }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">ISAI</span>

                            <span >${{ number_format($aviso['isai'], 2) }}</span>

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

                                    <button
                                        wire:click="abrirModalCobrar({{ json_encode($aviso) }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Cobrar
                                    </button>

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="10">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="15" class="bg-gray-50">

                        <div>
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex gap-3 justify-between">
                                <span>
                                    @if ($paginaAnterior)
                                        <button
                                         wire:click="previousPage"
                                         wire:loading.attr="disabled"
                                         rel="prev"
                                         class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                         x-on:click="$refs.tramites.scrollIntoView()">

                                            <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                            </svg>
                                          Anterior

                                        </button>
                                    @endif
                                </span>

                                <span>
                                    @if ($paginaSiguiente)
                                        <button
                                            wire:click="nextPage"
                                            wire:loading.attr="disabled"
                                            rel="next"
                                            class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                            x-on:click="$refs.tramites.scrollIntoView()">

                                            Siguiente

                                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>

                                        </button>
                                    @endif
                                </span>
                            </nav>
                        </div>

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            Cobrar ISAI

        </x-slot>

        <x-slot name="content">

            @if($aviso_seleccionado)

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="fecha_reduccion" label="Fecha de reducción" :error="$errors->first('fecha_reduccion')" class="w-full">

                        <x-input-text id="fecha_reduccion" value="{{ \Carbon\Carbon::parse($aviso_seleccionado['fecha_reduccion'])->format('d/m/Y') }}" readonly/>

                    </x-input-group>

                    <x-input-group for="fecha_limite_pago" label="Fecha límite de pago" :error="$errors->first('fecha_limite_pago')" class="w-full">

                        <x-input-text id="fecha_limite_pago" value="{{ \Carbon\Carbon::parse($fecha_limite_pago)->format('d/m/Y') }}" readonly/>

                    </x-input-group>

                    <x-input-group for="fecha_presentacion" label="Fecha de presentación" :error="$errors->first('fecha_presentacion')" class="w-full">

                        <x-input-text id="fecha_presentacion" value="{{ \Carbon\Carbon::parse($fecha_presentacion)->format('d/m/Y') }}" readonly/>

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="isai" label="ISAI" :error="$errors->first('isai')" class="w-full">

                        <x-input-text id="isai" value="${{ number_format($aviso_seleccionado['isai'], 2) }}" readonly/>

                    </x-input-group>

                    <x-input-group for="multas" label="Multas" :error="$errors->first('multas')" class="w-full">

                        <x-input-text id="multas" value="${{ number_format($multas, 2) }}" readonly/>

                    </x-input-group>

                    <x-input-group for="actualizacion" label="Actualización" :error="$errors->first('actualizacion')" class="w-full">

                        <x-input-text id="actualizacion" value="${{ number_format($actualizacion, 2) }}" readonly/>

                    </x-input-group>

                    <x-input-group for="recargos" label="Recargos" :error="$errors->first('recargos')" class="w-full">

                        <x-input-text id="recargos" value="${{ number_format($recargos, 2) }}" readonly/>

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="sin_multa" label="Sin multas" :error="$errors->first('sin_multa')" class="w-full">

                        <input type="checkbox" class="bg-white rounded text-xs " wire:model.live="sin_multa">

                    </x-input-group>

                    <x-input-group for="sin_recargo" label="Sin recargos" :error="$errors->first('sin_recargo')" class="w-full">

                        <input type="checkbox" class="bg-white rounded text-xs " wire:model.live="sin_recargo">

                    </x-input-group>

                    <x-input-group for="total" label="Total" :error="$errors->first('total')" class="w-full">

                        <x-input-text id="total" value="${{ number_format($total, 2) }}" readonly/>

                    </x-input-group>

                </div>


            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="cobrar"
                    wire:loading.attr="disabled"
                    wire:target="cobrar">

                    <img wire:loading wire:target="cobrar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Cobrar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modal')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
