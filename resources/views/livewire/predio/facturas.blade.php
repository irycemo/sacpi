<div class=" text-center">

    <div class="mb-5 bg-white rounded-lg shadow-xl p-4 w-full lg:w-1/2 mx-auto">

        <x-table>

            <x-slot name="head">
                <x-table.heading >Ejercicio Fiscal</x-table.heading>
                <x-table.heading >Bimestre</x-table.heading>
                <x-table.heading >Monto</x-table.heading>
                <x-table.heading >Estatus</x-table.heading>
            </x-slot>

            <x-slot name="body">

                @forelse ($predio->facturasEjercicioActual as $factura)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $factura->id }}">
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Ejercicio fiscal</span>
                            <span class="whitespace-nowrap">{{ $factura->ejercicio_fiscal }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimestre</span>
                            <span class="whitespace-nowrap">{{ $factura->bimestre }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Monto</span>
                            <span class="whitespace-nowrap">${{ number_format($factura->total,4) }}</span>
                        </x-table.cell>
                        <x-table.cell>
                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estatus</span>

                            <span class="whitespace-nowrap">

                                @if ($factura->status == 'facturado' || $factura->status == 'refacturado')

                                    <span class="bg-blue-400 py-1 px-2 rounded-full text-white text-xs">{{ Str::ucfirst($factura->status) }}</span>

                                @elseif($factura->status == 'PAGADO')

                                    <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ Str::ucfirst($factura->status) }}</span>

                                @else
                                    <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ Str::ucfirst($factura->status) }}</span>

                                @endif

                            </span>

                        </x-table.cell>
                    </x-table.row>

                @empty

                    <x-table.row wire:key="row-empty">

                        <x-table.cell colspan="9">

                            <div class="flex justify-center">

                                <x-button-blue
                                    wire:click="generarFacturas"
                                    wire:loading.attr="disabled">
                                    Generar facturación
                                </x-button-blue>

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

    @if($predio->facturasEjercicioActual->count())

        <div class="bg-white rounded-lg shadow-xl p-4 w-full lg:w-1/2 mx-auto">

            <x-button wire:loading.attr="disabled" wire:click="quitarAdeudo">
                {{ __('Quitar adeudo') }}
            </x-button>

        </div>

    @endif

</div>
