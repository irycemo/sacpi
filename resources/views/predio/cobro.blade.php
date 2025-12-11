@extends('layouts.admin')
@section('content')

<h4
    class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">
    Detalle de cobro
</h4>
<div class="space-y-1 columns-1 col-span-10" >
    <span class="bg-gray-400 py-1 px-2 rounded-full text-white text-sm" >Cuenta predial {{ $predio->cuentaPredial() }} </span>
    <span class="bg-gray-400 py-1 px-2 rounded-full text-white text-sm" >Predio {{ $tipocuota }} </span>

        @if($predio->primerPropietario() === null)
            <span class="bg-rojo py-1 px-2 rounded-full text-white text-sm" >
                Capturar Propietario(s)
            </span>
        @else
            <span class="bg-gray-500 py-1 px-2 rounded-full text-white text-sm" >
                Propietario {{ $predio->primerPropietario() }}
            </span>
        @endif

    <span class="bg-gray-600 py-1 px-2 rounded-full text-white text-sm" >Ubicación {{ $predio->Ubicacion() }}</span>

    @if(!$cuentacorriente[0])
        <br> <br>
        <span class="bg-rojo py-1 px-2 rounded-full text-white text-sm" >Predio sin facturas en cuenta corriente, si el predio debe tener adeudo ir a generarlo</span>
    @endif

    @if(!$rfacturas[0])
        <br> <br>
        <span class="bg-rojo py-1 px-2 rounded-full text-white text-sm" >Predio sin rezago</span>
    @endif


</div>
<br>
<div class="space-y-1 columns-1 col-span-10" >
    <span class="bg-black py-1 px-2 rounded-full text-white text-sm" >Adeudo Cuenta Corriente</span>
</div>
<x-table>
    <x-slot name="head">
        <x-table.heading >Concepto</x-table.heading>
        <x-table.heading >Impuesto</x-table.heading>
        <x-table.heading >Actualización</x-table.heading>
        <x-table.heading >Recargos</x-table.heading>
        <x-table.heading >Multas</x-table.heading>
        <x-table.heading >Requerimientos</x-table.heading>
        <x-table.heading >Subtotal</x-table.heading>
    </x-slot>
    <x-slot name="body">

        @forelse ($cuentacorriente as $item)
            @if ($cuentacorriente[0])
                <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $item[0]['id'] }}">
                <x-table.cell>
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Adeudo {{ now()->format('Y') }}</span>
                    <span class="whitespace-nowrap">{{ $item[0]['concepto'] }}</span>
                </x-table.cell>
                <x-table.cell style="text-align: right;">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimerstre 1</span>
                    <span class="whitespace-nowrap">${{ number_format($item[0]['impuesto'],4) }}</span>
                </x-table.cell>
                <x-table.cell style="text-align: right;">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimerstre 2</span>
                    <span class="whitespace-nowrap">${{ number_format($item[0]['actualizacion'],4) }}</span>
                </x-table.cell>
                <x-table.cell style="text-align: right;">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimerstre 3</span>
                    <span class="whitespace-nowrap">${{ number_format($item[0]['recargos'],4) }}</span>
                </x-table.cell>
                <x-table.cell style="text-align: right;">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimerstre 4</span>
                    <span class="whitespace-nowrap">${{ number_format($item[0]['multas'],4) }}</span>
                </x-table.cell>
                <x-table.cell style="text-align: right;">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimerstre 5</span>
                    <span class="whitespace-nowrap">${{ number_format($item[0]['requerimientos'],4) }}</span>
                </x-table.cell>
                <x-table.cell style="text-align: right;">
                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Bimerstre 6</span>
                    <span class="whitespace-nowrap">${{ number_format($item[0]['subtotal'],4) }}</span>
                </x-table.cell>

                </x-table.row>
            @endif
        @empty
            <x-table.row wire:key="row-empty">

                <x-table.cell colspan="9">

                    <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                        Predio sin adeudo en el año {{ now()->format('Y') }}

                    </div>

                </x-table.cell>

            </x-table.row>
        @endforelse
    </x-slot>


    <x-slot name="tfoot">
    </x-slot>



</x-table>
<br>
<div class="space-y-1 columns-1 col-span-10" >
    <span class="bg-black py-1 px-2 rounded-full text-white text-sm" >Adeudo Rezagos</span>
</div>
<x-table>
    <x-slot name="head">
        <x-table.heading >Año</x-table.heading>
        <x-table.heading >Impuesto</x-table.heading>
        <x-table.heading >Actualización</x-table.heading>
        <x-table.heading >Recargos</x-table.heading>
        <x-table.heading >Multas</x-table.heading>
        <x-table.heading >Requerimientos</x-table.heading>
        <x-table.heading >Subtotal</x-table.heading>
    </x-slot>
    <x-slot name="body">
        @if($rfacturas[0])
            @forelse ($rfacturas as $item)
                <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $item[0]['id'] }}">
                    <x-table.cell>
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Año</span>
                        <span class="whitespace-nowrap">{{ $item[0]['id'] }}</span>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Impuesto</span>
                        <span class="whitespace-nowrap">${{ number_format($item[0]['impuesto'], 4) }}</span>
                    </x-table.cell>
                    <x-table.cell style="text-align: right;">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualización</span>
                        <span class="whitespace-nowrap">${{ number_format($item[0]['actualizacion'], 4) }}</span>
                    </x-table.cell>
                    <x-table.cell style="text-align: right;">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Recargos</span>
                        <span class="whitespace-nowrap">${{ number_format($item[0]['recargos'], 4) }}</span>
                    </x-table.cell>
                    <x-table.cell style="text-align: right;">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Multas</span>
                        <span class="whitespace-nowrap">${{ number_format($item[0]['multas'], 4) }}</span>
                    </x-table.cell>
                    <x-table.cell style="text-align: right;">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Requerimientos</span>
                        <span class="whitespace-nowrap">${{ number_format($item[0]['requerimientos'], 4) }}</span>
                    </x-table.cell>
                    <x-table.cell style="text-align: right;">
                        <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Subtotal</span>
                        <span class="whitespace-nowrap">${{ number_format($item[0]['subtotal'], 4) }}</span>
                    </x-table.cell>

                </x-table.row>
            @empty
                <x-table.row wire:key="row-empty">

                    <x-table.cell colspan="9">

                        <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                            Predio sin rezagos

                        </div>

                    </x-table.cell>

                </x-table.row>
            @endforelse
        @endif

    </x-slot>

    <x-slot name="tfoot">
        <x-table.row>

            <x-table.cell colspan="13" class="bg-gray-50">

                {{-- {{ $facturas->links() }} --}}

            </x-table.cell>

        </x-table.row>
    </x-slot>
</x-table>

@livewire('predio.cobrar', ['totalapagar' => $totalapagar,'cuentacorriente' => $cuentacorriente,'rezago' =>$rfacturas,'tipocuota'=>$tipocuota,'predio'=>$predio])



@endsection
