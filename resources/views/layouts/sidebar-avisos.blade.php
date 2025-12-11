<div x-data="{openRoles:true, openDistritos:true, openValores:true, openPredios:true}" class="mb-5">

    <p class="uppercase text-base mb-2 border-b border-rojo rounded-lg px-1.5 w-full">TRASLADOS DE DOMINIO</p>

    @can('Consultar Traslados')

        <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

            <a href="{{ route('avisos') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-4 ">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
                </svg>

                Avisos Autorizados

            </a>

        </div>

    @endcan

</div>
