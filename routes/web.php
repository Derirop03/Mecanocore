<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;

Route::get('/', function () {
    return redirect('/ingreso');
});

// Ruta para VER el formulario
Route::get('/ingreso', [VehiculoController::class, 'create']);

// Ruta para GUARDAR el formulario
Route::post('/ingreso', [VehiculoController::class, 'store'])->name('guardar.vehiculo');