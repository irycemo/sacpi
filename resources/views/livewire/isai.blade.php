<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg ">

    <div class="flex flex-col lg:flex-row gap-3">

        <div class="w-full lg:w-1/4 mx-auto space-y-3">

            {{-- <div class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                <div class="flex items-center ps-3">
                    <input type="checkbox" wire:model="no_genera_isai" name="sin reducción" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                    <label for="sin reducción" class="w-full p-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No genera ISAI (fusiones, cuando las fracciones estan registradas al mismo propietario, divisiones, particiones y cuando no haya exedencia)</label>
                </div>

            </div> --}}

            {{--<x-input-group for="valor_adquisicion" label="Valor de adquisición" class="w-full">--}}

                <div style="flex: 1; padding: 10px; ">
                    <x-label for="valor_adquisicion" value="{{ __('Valor de adquisición') }}" />
                    <x-input type="number" id="valor_adquisicion" wire:model.live="valor_adquisicion" />
                    <x-input-error for="valor_adquisicion" class="mt-2" />
                </div>

            {{--/x-input-group>--}}

            <div>

                <span class="block text-sm font-medium leading-6 text-gray-900">Uso del predio</span>
                <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center ps-3">
                            <input value="vivienda" wire:model.live="uso_de_predio" id="horizontal-list-radio-license" type="radio" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="horizontal-list-radio-license" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Vivienda</label>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center ps-3">
                            <input value="otro" wire:model.live="uso_de_predio" id="horizontal-list-radio-id" type="radio" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="horizontal-list-radio-id" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Otro</label>
                        </div>
                    </li>
                    <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                        <div class="flex items-center ps-3">
                            <input value="mixto" wire:model.live="uso_de_predio" id="horizontal-list-radio-military" type="radio" name="list-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                            <label for="horizontal-list-radio-military" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Mixto</label>
                        </div>
                    </li>
                </ul>

                @error('uso_de_predio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>


            <div style="flex: 1; padding: 10px;" class="grid md:grid-cols-1 gap-2">
                <div>
                    <x-label for="fecha_reduccion" value="{{ __('Fecha de reducción') }}" />
                    <x-input type="date" id="fecha_reduccion" wire:model.live="fecha_reduccion" wire:blur="calcular_fechas" />
                    <x-input-error for="fecha_reduccion" class="mt-2" />
                </div>
                <div>
                    <x-label for="fecha_limite_pago" value="{{ __('Fecha límite de pago') }}" />
                    <x-input type="date" id="fecha_limite_pago" wire:model.live="fecha_limite_pago" />
                    <x-input-error for="fecha_limite_pago" class="mt-2" />
                </div>
                <div>
                    <x-label for="fecha_presentacion" value="{{ __('Fecha de presentación') }}" />
                    <x-input type="date" id="fecha_presentacion" wire:model.live="fecha_presentacion" />
                    <x-input-error for="fecha_presentacion" class="mt-2" />
                </div>
            </div>


            <div style="flex: 1; padding: 10px; ">
                <x-label for="valor_catastral" value="{{ __('Valor Catastral o Valor del avalúo') }}" />
                <x-input type="number" id="valor_catastral" wire:model.live="valor_catastral" />
                <x-input-error for="valor_catastral" class="mt-2" />
            </div>



            @if($uso_de_predio === 'mixto')

                <div style="flex: 1; padding: 10px; ">
                    <x-label for="valor_construccion_vivienda" value="{{ __('Valor de construcción de la vivienda (solo en uso mixto)') }}" />
                    <x-input type="number" id="valor_construccion_vivienda" wire:model.live="valor_construccion_vivienda" />
                    <x-input-error for="valor_construccion_vivienda" class="mt-2" />
                </div>

                <div style="flex: 1; padding: 10px; ">
                    <x-label for="valor_construccion_otro" value="{{ __('Valor de construcción de otro uso (solo en uso mixto)') }}" />
                    <x-input type="number" id="valor_construccion_otro" wire:model.live="valor_construccion_otro" />
                    <x-input-error for="valor_construccion_otro" class="mt-2" />
                </div>


            @endif

            <div style="flex: 1; padding: 10px; ">
                <x-label for="porcentaje_adquisicion" value="{{ __('Porcentaje (en caso de aplicar)') }}" />
                <x-input type="number" id="porcentaje_adquisicion" wire:model.live="porcentaje_adquisicion" />
                <x-input-error for="porcentaje_adquisicion" class="mt-2" />
            </div>



            <div class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                <div style="flex: 1; padding: 10px; ">
                    <input type="checkbox" wire:model="sin_reduccion" id="sin_reducción" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" />
                    <label for="sin reducción" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Predio sin reducción </label>
                </div>

            </div>

            <button
                wire:click="calcularIsai"
                wire:loading.attr="disabled"
                wire:target="calcularIsai"
                type="button"
                class="bg-blue-400 w-full hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                <img wire:loading wire:target="calcularIsai" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Calcular ISAI

            </button>



        </div>

        {{-- @if($aviso->valor_isai) --}}

            <div class="w-full lg:w-1/6 mx-auto space-y-3">

                <x-input-group for="base_gravable" label="Base gravable" class="w-full">

                    <x-input type="number" id="base_gravable" wire:model="base_gravable" readonly/>

                </x-input-group>

                <x-input-group for="reduccion" label="Reducción" class="w-full">

                    <x-input type="number" id="reduccion" wire:model="reduccion" readonly/>

                </x-input-group>

                <x-input-group for="valor_base" label="Valor base"  class="w-full">

                    <x-input type="number" id="valor_base" wire:model="valor_base" readonly/>

                </x-input-group>

                <x-input-group for="" label="Tasa (%)"  class="w-full">

                    <x-input type="number" id="" value="2" readonly/>

                </x-input-group>

                <x-input-group for="valor_isai" label="ISAI" class="w-full">

                    <x-input type="number" id="valor_isai" wire:model="valor_isai" readonly/>

                </x-input-group>

                <x-input-group for="multas" label="Multas" class="w-full">

                    <x-input type="number" id="multas" wire:model="multas" readonly/>

                </x-input-group>

                <x-input-group for="recargos" label="Recargos" class="w-full">

                    <x-input type="number" id="recargos" wire:model="recargos" readonly/>

                </x-input-group>

                <x-input-group for="total" label="Total" class="w-full">

                    <x-input type="number" id="total" wire:model="total" readonly/>

                </x-input-group>

            </div>

        {{-- @endif --}}



    </div>
    @if($uso_de_predio === 'mixto')
        <h4
                class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">
                Cálculos parciales cuando el uso es mixto


        </h4>
        <div class="grid md:grid-cols-4 gap-4">

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600 space-y-1">
                <div class="grid md:grid-cols-2 gap-4">
                    <strong>Porcentaje (%)</strong>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="porcentaje_vivienda" label="Vivienda" class="w-full">

                        <x-input type="number" id="porcentaje_vivienda" wire:model="porcentaje_vivienda" readonly/>

                    </x-input-group>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="porcentaje_otro_uso" label="Otro uso" class="w-full">

                        <x-input type="number" id="porcentaje_otro_uso" wire:model="porcentaje_otro_uso" readonly/>

                    </x-input-group>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="total_porcentajes" label="Total" class="w-full">

                        <x-input type="number" id="total_porcentajes" wire:model="total_porcentajes" readonly/>

                    </x-input-group>
                </div>

            </div>
            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600 space-y-1">
                <div class="grid md:grid-cols-2 gap-4">
                    <strong>Valor</strong>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="valor_total_vivienda" label="Vivienda" class="w-full">

                        <x-input type="number" id="valor_total_vivienda" wire:model="valor_total_vivienda" readonly/>

                    </x-input-group>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="valor_total_otro_uso" label="Otro uso" class="w-full">

                        <x-input type="number" id="valor_total_otro_uso" wire:model="valor_total_otro_uso" readonly/>

                    </x-input-group>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="total_valores" label="Total" class="w-full">

                        <x-input type="number" id="total_valores" wire:model="total_valores" readonly/>

                    </x-input-group>
                </div>
            </div>
            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600 space-y-1">
                <div class="grid md:grid-cols-2 gap-4">
                    <strong>Reducción</strong>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="reduccion_vivienda" label="Vivienda" class="w-full">

                        <x-input type="number" id="reduccion_vivienda" wire:model="reduccion_vivienda" readonly/>

                    </x-input-group>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="reduccion_otro_uso" label="Otro uso" class="w-full">

                        <x-input type="number" id="reduccion_otro_uso" wire:model="reduccion_otro_uso" readonly/>

                    </x-input-group>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <x-input-group for="reduccion" label="Total" class="w-full">

                        <x-input type="number" id="reduccion" wire:model="reduccion" readonly/>

                    </x-input-group>
                </div>

            </div>
            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600 space-y-1">
            </div>

        </div>
    @endif

</div>
