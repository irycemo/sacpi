<div>

    <x-header>Cobrar impuesto predial</x-header>

    @if(!$predio->getKey())

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-xl">

            <h4 class="text-lg text-center">Consultar predio</h4>

            <div class="flex-auto text-center ">

                <div class="space-y-1">

                    <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model="localidad">

                    <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model="oficina">

                    <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo_predio">

                    <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('numero_registro') border-1 border-red-500 @enderror" wire:model="numero_registro">

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

                </div>

            </div>

        </div>

    @else

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

            <div class="col-span-1 lg:col-span-9">

                <div class="space-y-2 mb-5 p-2">

                    <x-h4>Cuenta corriente</x-h4>

                    <div class="overflow-auto">

                        <x-table>

                            <x-slot name="head">
                                <x-table.heading >Ejercicio Fiscal</x-table.heading>
                                <x-table.heading >Bimestre</x-table.heading>
                                <x-table.heading >Impuesto</x-table.heading>
                                <x-table.heading >Actualización</x-table.heading>
                                <x-table.heading >Recargos</x-table.heading>
                                <x-table.heading >Multas</x-table.heading>
                                <x-table.heading >Requerimientos</x-table.heading>
                                <x-table.heading >Subtotal</x-table.heading>
                            </x-slot>

                            <x-slot name="body">

                                @forelse ($cuenta_corriente as $cuenta)

                                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $loop->iteration }}">
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Ejercicio fiscal</span>
                                            <span class="whitespace-nowrap">{{ $cuenta['ejercicio_fiscal'] }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimestre</span>
                                            <span class="whitespace-nowrap">{{ $cuenta['bimestre'] }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Monto</span>
                                            <span class="whitespace-nowrap">${{ number_format($cuenta['impuesto'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualización</span>
                                            <span class="whitespace-nowrap">${{ number_format($cuenta['actualizacion'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Recargos</span>
                                            <span class="whitespace-nowrap">${{ number_format($cuenta['recargos'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Multas</span>
                                            <span class="whitespace-nowrap">${{ number_format($cuenta['multas'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Requerimientos</span>
                                            <span class="whitespace-nowrap">${{ number_format($cuenta['requerimientos'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Subtotal</span>
                                            <span class="whitespace-nowrap">${{ number_format($cuenta['subtotal'], 2) }}</span>
                                        </x-table.cell>
                                    </x-table.row>

                                @empty

                                    <x-table.row wire:key="row-empty">

                                        <x-table.cell colspan="9">

                                            <div class="text-center space-y-5">

                                                <span class="text-base">El predio no tiene facturación para el ejercicio actual, generarla en la administración de predios.</span>

                                                <x-link-blue href="{{ route('predio_detalle', $predio) }}" class="w-fit mx-auto">
                                                    Ir a administración
                                                </x-link-blue>

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

                <div class="space-y-2 mb-5 rounded-lg p-2">

                    <x-h4>Rezagos</x-h4>

                    <div class="overflow-auto">

                        <x-table>

                            <x-slot name="head">
                                <x-table.heading >Ejercicio Fiscal</x-table.heading>
                                <x-table.heading >Impuesto</x-table.heading>
                                <x-table.heading >Actualización</x-table.heading>
                                <x-table.heading >Recargos</x-table.heading>
                                <x-table.heading >Multas</x-table.heading>
                                <x-table.heading >Requerimientos</x-table.heading>
                                <x-table.heading >Subtotal</x-table.heading>
                            </x-slot>

                            <x-slot name="body">

                                @forelse ($rezagos as $rezago)

                                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $loop->iteration }}">
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Ejercicio fiscal</span>
                                            <span class="whitespace-nowrap">{{ $rezago['ejercicio_fiscal'] }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Monto</span>
                                            <span class="whitespace-nowrap">${{ number_format($rezago['impuesto'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualización</span>
                                            <span class="whitespace-nowrap">${{ number_format($rezago['actualizacion'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Recargos</span>
                                            <span class="whitespace-nowrap">${{ number_format($rezago['recargos'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Multas</span>
                                            <span class="whitespace-nowrap">${{ number_format($rezago['multas'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Requerimientos</span>
                                            <span class="whitespace-nowrap">${{ number_format($rezago['requerimientos'], 2) }}</span>
                                        </x-table.cell>
                                        <x-table.cell>
                                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Subtotal</span>
                                            <span class="whitespace-nowrap">${{ number_format($rezago['subtotal'], 2) }}</span>
                                        </x-table.cell>
                                    </x-table.row>

                                @empty

                                    <x-table.row wire:key="row-empty">

                                        <x-table.cell colspan="9">

                                            <div class="text-center">

                                                <span class="text-base">El predio no tiene rezagos.</span>

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

            </div>

            <div class="bg-white rounded-lg shadow-xl p-4  col-span-1 lg:col-span-3">

                <div class="bg-gray-100 p-2 rounded-lg mb-5">

                    <p class="text-center">Descuento</p>

                    <div class="flex gap-1 items-end">

                        <x-input-group for="descuento_tipo" label="Tipo" class="w-full">

                            <x-input-select id="descuento_tipo" wire:model.lazy="descuento_tipo" class="w-full">

                                <option value="">Tipo</option>

                                @foreach ($descuentos_tipos as $tipo)

                                    <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>

                                @endforeach

                            </x-input-select>

                        </x-input-group>

                        <x-input-group for="descuento_accesorio" label="Accesorio" class="w-full">

                            <x-input-select id="descuento_accesorio" wire:model.lazy="descuento_accesorio" class="w-full">

                                <option value="">Accesorio</option>

                                @foreach ($descuentos_accesorios as $accesorio)

                                    <option value="{{ $accesorio }}">{{ ucfirst($accesorio) }}</option>

                                @endforeach

                            </x-input-select>

                        </x-input-group>

                        <x-input-group for="descuento_porcentaje" label="Porcentaje" class="w-full">

                            <x-input-select id="descuento_porcentaje" wire:model.lazy="descuento_porcentaje" class="w-full">

                                <option value="">%</option>

                                @foreach ($descuentos_porcentaje as $porcentaje)

                                    <option value="{{ $porcentaje }}">{{ ucfirst($porcentaje) }}</option>

                                @endforeach

                            </x-input-select>

                        </x-input-group>

                        <button
                            wire:click="agregarDescuento"
                            wire:loading.attr="disabled"
                            wire:target="agregarDescuento"
                            type="button"
                            class="bg-blue-400 rounded p-1 text-white text-lg mb-2"
                            >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>

                    </div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 mb-2">

                    <div class="bg-gray-100 p-2 rounded-lg text-gray-600">Subtotal</div>

                    <div class="bg-gray-100 p-2 rounded-lg text-gray-600 text-right">${{ number_format($subtotal, 2) }}</div>

                </div>

                <div>

                    @if(count($descuentos))

                        @foreach ($descuentos as $key => $descuento)

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 mb-2" wire:key="descuento-{{ $key }}">

                                <div class="bg-gray-100 px-2 py-3 rounded-lg text-gray-600 relative">

                                    <button
                                        wire:click="eliminarDescuento({{ $key }})"
                                        wire:loading.attr="disabled"
                                        wire:target="eliminarDescuento({{ $key }})"
                                        type="button"
                                        class="bg-red-400 rounded text-white mb-2 absolute right-1 top-1"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                        </svg>

                                    </button>

                                    <span class="text-sm">{{ ucfirst($descuento['tipo']) . '/' . $descuento['accesorio'] . '/' . number_format($descuento['porcentaje'], 2)}}</span>

                                </div>

                                <div class="bg-gray-100 p-2 rounded-lg text-gray-600 text-right">${{ number_format($descuento['monto'], 2) }}</div>

                            </div>

                        @endforeach

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 mb-2">

                            <div class="bg-gray-100 p-2 rounded-lg text-gray-600">Total de descuentos</div>

                            <div class="bg-gray-100 p-2 rounded-lg text-gray-600 text-right">${{ number_format(collect($descuentos)->sum('monto'), 2) }}</div>

                        </div>

                    @endif

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 mb-2">

                    <div class="bg-gray-100 p-2 rounded-lg text-gray-600">Total</div>

                    <div class="bg-gray-100 p-2 rounded-lg text-gray-600 text-right">${{ number_format($total_a_pagar, 2) }}</div>

                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-1 mb-2">

                    <div></div>

                    <div>

                        <x-input-group for="dinero_recibido" label="Recibido" :error="$errors->first('dinero_recibido')" class="w-full mb-3">

                            <x-input-text type="number" id="dinero_recibido" wire:model.lazy="dinero_recibido" leadingAddOn="$"/>

                        </x-input-group>

                        <x-input-group label="Cambio" class="w-full mb-3" for="cambio">

                            <x-input-text value="{{ number_format($cambio, 2) }}" id="dinero_recibido" leadingAddOn="$" readonly/>

                        </x-input-group>

                    </div>

                </div>

                <div>

                    <x-button-blue
                        wire:click="cobrar"
                        wire:loading.attr="disabled"
                        wire:target="cobrar"
                        class="w-full">
                        Cobrar
                    </x-button-blue>

                </div>

            </div>

        </div>

    @endif

</div>
