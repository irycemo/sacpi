<?php

use App\Livewire\Isai;
use App\Livewire\Admin\Umas;
use App\Livewire\Admin\Roles;
use App\Livewire\Avisos\Avisos;
use App\Livewire\Admin\Oficinas;
use App\Livewire\Admin\Permisos;
use App\Livewire\Admin\Usuarios;
use App\Livewire\Admin\Descuentos;
use App\Livewire\Consultas\Predios;
use App\Livewire\Parametros\Valores;
use App\Livewire\Admin\CuotasMinimas;
use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\FactorIncremento;
use App\Livewire\Admin\ValoresGenerales;
use App\Livewire\Cobros\Predial\Predial;
use App\Livewire\Padron\Captura\Captura;
use App\Http\Controllers\PredioController;
use App\Livewire\Consultas\ConsultaPadron;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetPasswordController;

Route::get('/', function () {
    return redirect('login');
});

Route::group(['middleware' => ['auth', 'activo']], function(){

    /* Administración */
    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::get('roles', Roles::class)->middleware('permission:Lista de roles')->name('roles');

    Route::get('permisos', Permisos::class)->middleware('permission:Lista de permisos')->name('permisos');

    Route::get('usuarios', Usuarios::class)->middleware('permission:Lista de usuarios')->name('usuarios');

    Route::get('oficinas', Oficinas::class)->middleware('permission:Lista de oficinas')->name('oficinas');

    Route::get('descuentos', Descuentos::class)->middleware('permission:Lista de descuentos')->name('descuentos');

    Route::get('umas', Umas::class)->middleware('permission:Lista de umas')->name('umas');

    Route::get('factor_incremento', FactorIncremento::class)->middleware('permission:Lista de factor incremento')->name('factor_incremento');

    Route::get('valores_generales', ValoresGenerales::class)->middleware('permission:Valores generales')->name('valores_generales');

    Route::get('cuotas_minimas', CuotasMinimas::class)->middleware('permission:Cuotas minimas')->name('cuotas_minimas');

    /* Padron */
    Route::get('predios', Predios::class)->middleware('permission:Lista de predios')->name('predios');

    Route::get('ver_predio/{predio}', [PredioController::class, 'verPredio'])->middleware('permission:Ver predio')->name('ver_predio');

    Route::get('predio_detalle/{predio}', [PredioController::class, 'verDetalle'])->middleware('permission:Ver predio')->name('predio_detalle');

    Route::get('consulta_padron', ConsultaPadron::class)->middleware('permission:Consulta Padrón')->name('consulta_padron');

    Route::get('captura_padron', Captura::class)->middleware('permission:Captura al padron')->name('captura_padron');

    /* Avisos */
    Route::get('avisos', Avisos::class)->middleware('permission:Consultar Traslados')->name('avisos');

    /* Cobros */
    Route::get('cobro_predial/{predio?}', Predial::class)->middleware('permission:Cobro Predial')->name('cobro_predial');

    Route::get('cobro_isai', Isai::class)->middleware('permission:Cobro ISAI')->name('cobro_isai');

    /* Parametros */
    Route::get('valores', Valores::class)->name('valores');

});

Route::get('setpassword/{email}', [SetPasswordController::class, 'create'])->name('setpassword');
Route::post('setpassword', [SetPasswordController::class, 'store'])->name('setpassword.store');
