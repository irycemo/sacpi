<div>

    <div class="bg-white rounded-lg shadow-xl p-4 w-full lg:w-1/2 mx-auto">

        <x-table>

            <x-slot name="head">
                <x-table.heading >Folio</x-table.heading>
                <x-table.heading >Estado</x-table.heading>
                <x-table.heading >Fecha</x-table.heading>
                <x-table.heading >Cajero</x-table.heading>
                <x-table.heading >Total</x-table.heading>
                <x-table.heading >Medio de Pago</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>
            </x-slot>

            <x-slot name="body">

                @forelse ($predio->pagos as $item)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $item->id }}">

                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>
                            <span class="whitespace-nowrap">{{ $item->año }}-{{ $item->folio }}-{{ $item->usuario }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>
                            <span>{{ ucfirst($item->status) }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha</span>
                            <span class="whitespace-nowrap">{{ $item->fecha_pago_formateada }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cajero</span>
                            <span >{{ $item->creadoPor->name }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Total</span>
                            <span>${{ number_format($item->total, 2) }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Medio de Pago</span>
                            <span>{{ ucfirst($item->medio_pago) }}</span>
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
                                        wire:click="abrirModalVer({{ $item->id }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver pago
                                    </button>

                                    @if($item->status == 'pagado')

                                        <button
                                            wire:click="abrirModalCancelar({{ $item->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Cancelar
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

                                    <span class="text-base">El predio no tiene pagos.</span>

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

    <x-dialog-modal wire:model="modal_cancelar" maxWidth="sm">

        <x-slot name="title">
            Cancelar Pago
        </x-slot>

        <x-slot name="content">

            <div>

                <x-input-group for="motivo" label="Motivo" :error="$errors->first('motivo')" class="w-full">

                    <textarea
                        class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        wire:model="motivo" rows="5">
                    </textarea>

                </x-input-group>

            </div>

        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modal_cancelar')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="cancelarPago"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Cancelar
            </x-danger-button>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modal_ver">

        <x-slot name="title">
            Pago
        </x-slot>

        <x-slot name="content">

            @if($pago)

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2 mb-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Folio:</strong> {{ $pago->año }}-{{ $pago->folio }}-{{ $pago->usuario }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Fecha de pago:</strong> {{ $pago->fecha_pago_formateada }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Estado:</strong> {{ ucfirst($pago->status) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo:</strong> {{ ucfirst($pago->tipo) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Medio de pago:</strong> {{ ucfirst($pago->medio_pago) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Total:</strong> ${{ number_format($pago->total, 2) }}</p>

                    </div>

                    @if($pago->linea_captura)

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Línea de captura:</strong> {{ $pago->linea_captura }}</p>

                        </div>

                    @endif

                    @if($pago->status == 'cancealdo')

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Cancelado por:</strong> {{ $pago->actualizadoPor->name }}</p>

                        </div>

                    @endif

                </div>

                @if($pago->observaciones)

                    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2">

                        <p><strong>Observaciones:</strong> {{ $pago->observaciones }}</p>

                    </div>

                @endif

                <p class="text-center tracking-widest font-semibold">Detalles</p>

                <div class="overflow-x-auto w-full">

                    <table class="table-auto lg:table-fixed">

                        <thead class="border-b border-gray-300 ">

                            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                                <th class="px-2">Concepto</th>
                                <th class="px-2">Tipo</th>
                                <th class="px-2">Impuesto</th>
                                <th class="px-2">Actualización</th>
                                <th class="px-2">Recargos</th>
                                <th class="px-2">Multas</th>
                                <th class="px-2">Requerimientos</th>
                                <th class="px-2">Subtotal</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($pago->detalles as $detalle)

                                <tr class="text-gray-500 text-sm leading-relaxed">
                                    <td class="px-2">{{ $detalle->concepto }}</td>
                                    <td class="px-2">{{ ucfirst($detalle->tipo) }}</td>
                                    <td class="px-2">${{ number_format($detalle->impuesto, 2) }}</td>
                                    <td class="px-2">${{ number_format($detalle->actualizacion, 2) }}</td>
                                    <td class="px-2">${{ number_format($detalle->recargos, 2) }}</td>
                                    <td class="px-2">${{ number_format($detalle->multas, 2) }}</td>
                                    <td class="px-2">${{ number_format($detalle->requerimientos, 2) }}</td>
                                    <td class="px-2">${{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @if($descuentos->count())

                    <p class="text-center tracking-widest font-semibold mt-5">Descuentos</p>

                    <table class="table-auto lg:table-fixed w-full">

                        <thead class="border-b border-gray-300 ">

                            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                                <th class="px-2">Tipo</th>
                                <th class="px-2">Accesorio</th>
                                <th class="px-2">%</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @foreach ($descuentos as $descuento)

                                <tr class="text-gray-500 text-sm leading-relaxed">
                                    <td>{{ ucfirst($descuento->tipo) }}</td>
                                    <td>{{ ucfirst($descuento->accesorio) }}</td>
                                    <td>{{ $descuento->porcentaje }}</td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @endif

            @endif

        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modal_ver')"
                wire:loading.attr="disabled"
            >
                Cerrar
            </x-secondary-button>

        </x-slot>

    </x-dialog-modal>

</div>
