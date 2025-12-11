<div>

    <x-header>Valores</x-header>

    <div class="bg-white rounded-lg p-4 shadow-xl">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:w-1/2 mx-auto gap-4">

            <div class="space-y-2">

                <x-input-group for="parametro.nombre_titular" label="Nombre del titular" :error="$errors->first('parametro.nombre_titular')" class="w-full">

                    <x-input-text id="parametro.nombre_titular" wire:model="parametro.nombre_titular" />

                </x-input-group>

                <x-input-group for="parametro.tasa_isai" label="Tasa de ISAI" :error="$errors->first('parametro.tasa_isai')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_isai" wire:model="parametro.tasa_isai" />

                </x-input-group>

                <x-input-group for="parametro.cuota_minima_isai" label="Cuota minima de ISAI" :error="$errors->first('parametro.cuota_minima_isai')" class="w-full">

                    <x-input-text type="number" id="parametro.cuota_minima_isai" wire:model="parametro.cuota_minima_isai" />

                </x-input-group>

                <x-input-group for="parametro.tasa_recargos_isai" label="Tasa de recargos ISAI" :error="$errors->first('parametro.tasa_recargos_isai')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_recargos_isai" wire:model="parametro.tasa_recargos_isai" />

                </x-input-group>

                <x-input-group for="parametro.cuota_minima_predial_urbanos" label="Cuota minima de predial (Urbanos)" :error="$errors->first('parametro.cuota_minima_predial_urbanos')" class="w-full">

                    <x-input-text type="number" id="parametro.cuota_minima_predial_urbanos" wire:model="parametro.cuota_minima_predial_urbanos" />

                </x-input-group>

                <x-input-group for="parametro.cuota_minima_predial_rusticos" label="Cuota minima de predial (Rusticos)" :error="$errors->first('parametro.cuota_minima_predial_rusticos')" class="w-full">

                    <x-input-text type="number" id="parametro.cuota_minima_predial_rusticos" wire:model="parametro.cuota_minima_predial_rusticos" />

                </x-input-group>

                <x-input-group for="parametro.cuota_minima_ejidal_urbanos" label="Cuota minima de predial (Ejidal urbanos)" :error="$errors->first('parametro.cuota_minima_ejidal_urbanos')" class="w-full">

                    <x-input-text type="number" id="parametro.cuota_minima_ejidal_urbanos" wire:model="parametro.cuota_minima_ejidal_urbanos" />

                </x-input-group>

                <x-input-group for="parametro.cuota_minima_ejidal_rusticos" label="Cuota minima de predial (Ejidal rusticos)" :error="$errors->first('parametro.cuota_minima_ejidal_rusticos')" class="w-full">

                    <x-input-text type="number" id="parametro.cuota_minima_ejidal_rusticos" wire:model="parametro.cuota_minima_ejidal_rusticos" />

                </x-input-group>

                <x-input-group for="parametro.tasa_rusticos_ejidales" label="Tasa predios rusticos ejidales" :error="$errors->first('parametro.tasa_rusticos_ejidales')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_rusticos_ejidales" wire:model="parametro.tasa_rusticos_ejidales" />

                </x-input-group>

            </div>

            <div class="space-y-2">

                <x-input-group for="parametro.tasa_urbanos_1980" label="Tasa predios urbanos 1980" :error="$errors->first('parametro.tasa_urbanos_1980')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_urbanos_1980" wire:model="parametro.tasa_urbanos_1980" />

                </x-input-group>

                <x-input-group for="parametro.tasa_urbanos_81a83" label="Tasa predios urbanos 1981-1983" :error="$errors->first('parametro.tasa_urbanos_81a83')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_urbanos_81a83" wire:model="parametro.tasa_urbanos_81a83" />

                </x-input-group>

                <x-input-group for="parametro.tasa_urbanos_84y85" label="Tasa predios urbanos 1984-1985" :error="$errors->first('parametro.tasa_urbanos_84y85')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_urbanos_84y85" wire:model="parametro.tasa_urbanos_84y85" />

                </x-input-group>

                <x-input-group for="parametro.tasa_urbanos_1986" label="Tasa predios urbanos 1986" :error="$errors->first('parametro.tasa_urbanos_1986')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_urbanos_1986" wire:model="parametro.tasa_urbanos_1986" />

                </x-input-group>

                <x-input-group for="parametro.tasa_urbanos_ejidales" label="Tasa predios urbanos ejidales" :error="$errors->first('parametro.tasa_urbanos_ejidales')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_urbanos_ejidales" wire:model="parametro.tasa_urbanos_ejidales" />

                </x-input-group>

                <x-input-group for="parametro.tasa_rusticos_1980" label="Tasa predios rusticos 1980" :error="$errors->first('parametro.tasa_rusticos_1980')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_rusticos_1980" wire:model="parametro.tasa_rusticos_1980" />

                </x-input-group>

                <x-input-group for="parametro.tasa_rusticos_81a83" label="Tasa predios rusticos 1981-1983" :error="$errors->first('parametro.tasa_rusticos_81a83')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_rusticos_81a83" wire:model="parametro.tasa_rusticos_81a83" />

                </x-input-group>

                <x-input-group for="parametro.tasa_rusticos_84y85" label="Tasa predios rusticos 1984-1985" :error="$errors->first('parametro.tasa_rusticos_84y85')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_rusticos_84y85" wire:model="parametro.tasa_rusticos_84y85" />

                </x-input-group>

                <x-input-group for="parametro.tasa_rusticos_1986" label="Tasa predios rusticos 1986" :error="$errors->first('parametro.tasa_rusticos_1986')" class="w-full">

                    <x-input-text type="number" id="parametro.tasa_rusticos_1986" wire:model="parametro.tasa_rusticos_1986" />

                </x-input-group>

            </div>

        </div>

        <div class="flex justify-center mt-5">

            <x-button-blue
                wire:click="actualizar"
                wire:loading.attr="disabled"
                wire:target="actualizar">
                Actualizar
            </x-button-blue>

        </div>

    </div>

</div>
