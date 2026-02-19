<div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg ">

    <div class="flex flex-col lg:flex-row gap-3">

        <div class="w-full lg:w-1/4 mx-auto space-y-3">

            <x-input-group for="valor_adquisicion" label="Valor de adquisición" :error="$errors->first('valor_adquisicion')" class="w-full">

                <x-input-text type="number" id="valor_adquisicion" wire:model="valor_adquisicion" />

            </x-input-group>

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

            <x-input-group for="fecha_reduccion" label="Fecha de reducción" :error="$errors->first('fecha_reduccion')" class="w-full">

                <x-input-text type="number" id="fecha_reduccion" wire:model="fecha_reduccion" />

            </x-input-group>

            <x-input-group for="fecha_limite_pago" label="Fecha límite de pago" :error="$errors->first('fecha_limite_pago')" class="w-full">

                <x-input-text type="number" id="fecha_limite_pago" wire:model="fecha_limite_pago" />

            </x-input-group>

            <x-input-group for="fecha_presentacion" label="Fecha de presentación" :error="$errors->first('fecha_presentacion')" class="w-full">

                <x-input-text type="number" id="fecha_presentacion" wire:model="fecha_presentacion" />

            </x-input-group>

            <x-input-group for="valor_catastral" label="Valor Catastral o Valor del avalúo" :error="$errors->first('valor_catastral')" class="w-full">

                <x-input-text type="number" id="valor_catastral" wire:model="valor_catastral" />

            </x-input-group>

            @if($uso_de_predio === 'mixto')

                <x-input-group for="valor_construccion_vivienda" label="Valor de construcción de la vivienda (solo en uso mixto)" :error="$errors->first('valor_construccion_vivienda')" class="w-full">

                    <x-input-text type="number" id="valor_construccion_vivienda" wire:model="valor_construccion_vivienda" />

                </x-input-group>

                <x-input-group for="valor_construccion_otro" label="Valor de construcción de otro uso (solo en uso mixto)" :error="$errors->first('valor_construccion_otro')" class="w-full">

                    <x-input-text type="number" id="valor_construccion_otro" wire:model="valor_construccion_otro" />

                </x-input-group>

            @endif

            <x-input-group for="porcentaje_adquisicion" label="Porcentaje (en caso de aplicar)" :error="$errors->first('porcentaje_adquisicion')" class="w-full">

                <x-input-text type="number" id="porcentaje_adquisicion" wire:model="porcentaje_adquisicion" />

            </x-input-group>

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

    </div>

    @if($uso_de_predio === 'mixto')

        <x-h4>Cálculos parciales cuando el uso es mixto</x-h4>

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

        </div>

    @endif

</div>
