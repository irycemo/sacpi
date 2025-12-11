@extends('layouts.admin')

@section('content')

    <x-header>Administrar predio: {{ $predio->cuentaPredial() }}</x-header>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 lg:grid-cols-6 gap-3 mb-5">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor Catastral</strong>

                <p>$ {{ number_format($predio->valor_catastral,4) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de efectos</strong>

                <p>{{ $predio->fecha_efectos_formateada }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tasa</strong>

                <p>{{ $tasa }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Impuesto Anual</strong>

                <p>${{ number_format($impuesto_anual,4) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de cuota</strong>

                <p>Cuota {{ $tipo_cuota }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de Predio</strong>

                @if ($predio->tipo_predio == 1)
                    <p>Urbano</p>
                @else
                    <p>Rústico</p>
                @endif

            </div>

        </div>

        <div class="flex justify-end">

            <x-link-blue
                href="{{ route('cobro_predial', $predio) }}">
                Cobrar
            </x-link-blue>

        </div>

    </div>

    <div class="tab-wrapper max-h-full" x-data="{ activeTab: 0 }">

        <div class="flex py-4 space-x-4 items-center border-b-2 border-gray-500 mb-6 flex-wrap justify-center">

            <label @click="activeTab = 0"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 0 }">
                Facturación {{ now()->format('Y') }}
            </label>

            <label @click="activeTab = 1"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 1 }">
                Rezagos
            </label>

            <label @click="activeTab = 2"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 2 }">
                Pagos
            </label>

            <label @click="activeTab = 5"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 5 }">
                Invitaciones
            </label>

            <label @click="activeTab = 3"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 3 }">
                Requerimientoss
            </label>

            <label @click="activeTab = 4"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 4 }">
                Constancia de no adeudo
            </label>

        </div>

        <div class="p-2">

            <div class="tab-panel" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.800="activeTab === 0"  wire:key="tab-0">

                @livewire('predio.facturas', ['predio' => $predio, 'tipo_cuota' => $tipo_cuota, 'impuesto_anual' => $impuesto_anual])

            </div>

            <div class="tab-panel" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.800="activeTab === 1"  wire:key="tab-1">

                @include('predio.rezagos')

            </div>

            <div class="tab-panel" :class="{ 'active': activeTab === 2 }" x-show.transition.in.opacity.duration.800="activeTab === 2"  wire:key="tab-2">
                @livewire('predio.pagos', ['predio' => $predio])
            </div>

            <div class="tab-panel" :class="{ 'active': activeTab === 5 }" x-show.transition.in.opacity.duration.800="activeTab === 5"  wire:key="tab-5">
                @livewire('predio.invitaciones', ['predio' => $predio, 'tipo_cuota' => $tipo_cuota])
            </div>

            <div class="tab-panel" :class="{ 'active': activeTab === 3 }" x-show.transition.in.opacity.duration.800="activeTab === 3"  wire:key="tab-3">
                @livewire('predio.requerimientos', ['predio' => $predio, 'tipo_cuota' => $tipo_cuota])
            </div>

            <div class="tab-panel" :class="{ 'active': activeTab === 4 }" x-show.transition.in.opacity.duration.800="activeTab === 4"  wire:key="tab-4">
                @livewire('predio.constancias', ['predio' => $predio])
            </div>

        </div>

    </div>

@endsection
