
<div>
    <br>

    <x-form-section submit="">
        <x-slot name="title">
            {{ __('Datos de cobro') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Información de cobro') }}
        </x-slot>

        <x-slot name="form">
            <div class="space-y-1 columns-1 col-span-10" >
                <span class="bg-blue-400 py-1 px-2 rounded-full text-white text-sm" >Cobro</span>
            </div>
            <div class="space-y-1 columns-1 col-span-10">
                <div style="display: flex; gap: 10px;">

                    {{-- <div style="flex: 1; padding: 10px; ">
                        <x-label for="nopaquete" value="{{ __('Tipo de cuota') }}" />
                        <x-input  type="text" value="{{ $tipocuota }}" readonly class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="tipocuota"/>
                        <x-input-error for="tipocuota" class="mt-2" />
                    </div> --}}
                    <div style="flex: 1; padding: 10px; ">
                        <x-label for="totalapagar" value="{{ __('Monto a pagar') }}" />
                        <x-input  type="text" value="{{ $totalapagar }}" readonly class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="totalapagar"/>
                        <x-input-error for="totalapagar" class="mt-2" />
                    </div>
                    <div style="flex: 1; padding: 10px; ">
                        <x-label for="entrego" value="{{ __('Entrego') }}" />
                        <x-input  type="text" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="entrego"/>
                        <x-input-error for="entrego" class="mt-2" />
                    </div>
                    <div style="flex: 1; padding: 10px; ">
                        <x-label for="cambio" value="{{ __('Cambio') }}" />
                        <x-input  type="text" readonly value="{{ $cambio }}" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="cambio"/>
                        <x-input-error for="cambio" class="mt-2" />
                    </div>
                </div>

            </div>
            <div class="space-y-1 columns-1 col-span-10" >
                <span class="bg-blue-400 py-1 px-2 rounded-full text-white text-sm" >Descuentos</span>
            </div>
            <div class="space-y-1 columns-1 col-span-6">
                <div class="space-y-1 columns-1 col-span-4">
                    @foreach ($ds as $descuento)
                    <div style="display: flex; gap: 5px;">
                        <x-button wire:loading.attr="disabled" wire:click="descuento({{$descuento->id}})">
                            {{$descuento->nombre}} {{number_format($descuento->porcentaje,0)}}%
                        </x-button>

                        <x-label for="valor_{{ $descuento->id }}"/>
                        <x-input  type="text" readonly class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" wire:model.defer="cambio"/>
                        <x-input-error for="valor_{{ $descuento->id }}" class="mt-2" />

                    </div>

                    @endforeach

                </div>
            </div>
        </x-slot>

        <x-slot name="actions">


        @can('Cobro Impuesto Predial')
            <x-button wire:loading.attr="disabled" wire:click="cobrar">
                {{ __('Cobrar') }}
            </x-button>
        @endcan

        </x-slot>
    </x-form-section>
</div>
