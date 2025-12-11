<div>

    <x-header>Captura al padrón predial</x-header>

    <div class="tab-wrapper max-h-full" x-data="{ activeTab: 0 }">

        <div class="flex py-4 space-x-4 items-center border-b-2 border-gray-500 mb-6 flex-wrap justify-center">

            <label
                @click="activeTab = 0"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 0 }"
            >Información del inmueble
            </label>

            <label
                @click="activeTab = 1"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 1 }"
            >Colindancias
            </label>

            <label
                @click="activeTab = 2"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 2 }"
            >Propietarios
            </label>

        </div>

        @if($predio->getKey())

            <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right">

                <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Predio: {{ $predio->cuentaPredial() }}</span>

            </div>

        @endif

        <div class="tab-panel" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.800="activeTab === 0"  wire:key="tab-0">

            @include('livewire.padron.captura.identificacion')

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.800="activeTab === 1"  wire:key="tab-1">

            @livewire('padron.captura.colindancias')

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 2 }" x-show.transition.in.opacity.duration.800="activeTab === 2"  wire:key="tab-2">

            @livewire('padron.captura.propietarios')

        </div>

    </div>

    <x-confirmation-modal wire:model="modalIndexar" maxWidth="sm">

        <x-slot name="title">
            Indexar valor catastral
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea indexar el valor catastral?
        </x-slot>

        <x-slot name="footer">

            <x-danger-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-danger-button>

            <x-secondary-button
                class="ml-2"
                wire:click="indexar"
                wire:loading.attr="disabled"
                wire:target="indexar"
            >
                Indexar
            </x-secondary-button>

        </x-slot>

    </x-confirmation-modal>

    <x-dialog-modal wire:model="modalBaja" maxWidth="sm">

        <x-slot name="title">
            Dar de baja el predio
        </x-slot>

        <x-slot name="content">

            <x-input-group for="predio.origen" label="Motivo" :error="$errors->first('predio.origen')" class="w-full">

                <x-input-select id="predio.origen" wire:model="predio.origen">

                    <option value="" selected>Seleccione una opción</option>

                    @foreach ($acciones_baja as $accion)

                        <option value="{{ $accion }}">{{ $accion }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones" placeholder="Se lo más explicito en el motivo por el cual se da de baja el predio mencionando oficio si se ha presentado."></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="darDeBaja"
                    wire:loading.attr="disabled"
                    wire:target="darDeBaja">

                    <img wire:loading wire:target="darDeBaja" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Dar de baja</span>
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalBaja')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalBaja')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
