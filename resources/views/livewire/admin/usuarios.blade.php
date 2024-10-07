<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Usuarios</h1>

        <div class="flex justify-between items-center ">

            <div class="space-y-2">

                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm ">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.rol">

                    <option value="">Seleccione un rol</option>

                    @foreach ($roles as $rol)

                        <option value="{{ $rol->name }}">{{ $rol->name }}</option>

                    @endforeach

                </select>

                <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

            @can('Crear usuario')

                <div class="">

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                        <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        Agregar nuevo usuario

                    </button>

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full md:hidden focus:outline-gray-400 focus:outline-offset-2">+</button>

                </div>

            @endcan

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('status')" :direction="$sort === 'status' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('name')" :direction="$sort === 'name' ? $direction : null" >Nombre</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('email')" :direction="$sort === 'email' ? $direction : null" >Correo</x-table.heading>
                <x-table.heading >Rol</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($usuarios as $usuario)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $usuario->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Status</span>

                            @if($usuario->status == 'activo')

                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->status) }}</span>

                            @else

                                <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->status) }}</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre</span>

                            <div class="flex items-center justify-center lg:justify-start">

                                <img class="h-10 w-10 rounded-full" src="{{ $usuario->profile_photo_url }}" alt="{{ $usuario->name }}">

                                <span class="text-sm text-gray-900 ml-4">{{ $usuario->name }}</span>

                            </div>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Email</span>

                            {{ $usuario->email }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Role</span>

                            @if ($usuario->roles()->count())

                                {{ $usuario->getRoleNames()->first() }}

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($usuario->creadoPor != null)Registrado por: {{$usuario->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $usuario->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($usuario->actualizadoPor != null)Actualizado por: {{$usuario->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $usuario->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex flex-col justify-center lg:justify-start gap-2">

                                @can('Editar usuario')

                                    <x-button-blue
                                        wire:click="abrirModalEditar({{ $usuario->id }})"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>

                                        <span>Editar</span>

                                    </x-button-blue>

                                @endcan

                                @can('Borrar usuario')

                                    <x-button-red
                                        wire:click="abrirModalBorrar({{ $usuario->id }})"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                        <span>Eliminar</span>

                                    </x-button-red>

                                @endcan

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="10">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="10" class="bg-gray-50">

                        {{ $usuarios->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            @if($crear)
                Nuevo Usuario
            @elseif($editar)
                Editar Usuario
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.name" label="Nombre" :error="$errors->first('modelo_editar.name')" class="w-full">

                        <x-input-text id="modelo_editar.name" wire:model="modelo_editar.name" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.email" label="Correo" :error="$errors->first('modelo_editar.email')" class="w-full">

                        <x-input-text id="modelo_editar.email" wire:model="modelo_editar.email" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.status" label="Estado" :error="$errors->first('modelo_editar.status')" class="w-full">

                        <x-input-select id="modelo_editar.status" wire:model="modelo_editar.status" class="w-full">

                            <option value="">Seleccione una opción</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>

                        </x-input-select>

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="role" label="Rol" :error="$errors->first('role')" class="w-full">

                        <x-input-select id="role" wire:model="role" class="w-full">

                            <option value="">Seleccione una opción</option>

                            @foreach ($roles as $role)

                                <option value="{{ $role->id }}">{{ $role->name }}</option>

                            @endforeach

                        </x-input-select>

                    </x-input-group>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                @if($crear)

                    <x-button-blue
                        wire:click="guardar"
                        wire:loading.attr="disabled"
                        wire:target="guardar">

                        <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Guardar
                    </x-button-blue>

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Actualizar
                    </x-button-blue>

                @endif

                <x-button-red
                    wire:click="resetearTodo"
                    wire:loading.attr="disabled"
                    wire:target="resetearTodo"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar Usuario
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar al usuario? No sera posible recuperar la información.
        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
