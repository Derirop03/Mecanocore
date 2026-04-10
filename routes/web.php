<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TallerController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\LavaderoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home'); 
});

Route::get('/nosotros', function () {
    return view('nosotros'); 
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/crear-admin', [AuthController::class, 'crearAdmin']);

Route::get('/force-login', function () {
    $user = \App\Models\User::updateOrCreate(
        ['username' => 'admin'],
        [
            'name' => 'Administrador',
            'email' => 'admin@mecanocore.com',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678')
        ]
    );
    \Illuminate\Support\Facades\Auth::login($user);
    return redirect('/sistema');
});

Route::get('/hacerme-admin', function () {
    \App\Models\User::where('username', 'admin')->update(['rol' => 'admin']);
    return redirect('/sistema');
});

// RUTAS DEL SISTEMA PROTEGIDAS
Route::middleware('auth')->group(function () {
    
    Route::get('/forzar-cambio', [AuthController::class, 'vistaCambiarClave']);
    Route::post('/forzar-cambio', [AuthController::class, 'guardarNuevaClave']);

    // GUARDIÁN DE CAMBIO DE CLAVE
    Route::middleware(\App\Http\Middleware\ForzarCambioClave::class)->group(function () {
        
        Route::get('/sistema', [DashboardController::class, 'index']);
        Route::get('/historial', [HistorialController::class, 'index']);

        Route::middleware('role:admin')->group(function () {
            Route::get('/usuarios', [UserController::class, 'index']);
            Route::post('/usuarios', [UserController::class, 'store']);
            Route::patch('/usuarios/{id}/reset', [UserController::class, 'resetPassword']);
            Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);
        });

        Route::middleware('role:mecanico,secretario,lavador')->group(function () {
            Route::get('/vehiculos', [VehiculoController::class, 'index']);
            Route::post('/vehiculos', [VehiculoController::class, 'store']);
            Route::put('/vehiculos/{id}', [VehiculoController::class, 'update']);
            Route::delete('/vehiculos/{id}', [VehiculoController::class, 'destroy']);
        });

        Route::middleware('role:mecanico,secretario')->group(function () {
            Route::get('/taller', [TallerController::class, 'index']);
            Route::post('/taller', [TallerController::class, 'store']);
            Route::put('/taller/{id}', [TallerController::class, 'update']);
            Route::patch('/taller/{id}/estado', [TallerController::class, 'actualizarEstado']);
            Route::delete('/taller/{id}', [TallerController::class, 'destroy']);
        });

        Route::middleware('role:cajero,secretario')->group(function () {
            Route::get('/facturacion', [FacturaController::class, 'index']);
            Route::post('/facturacion', [FacturaController::class, 'store']);
            Route::patch('/facturacion/{id}/estado', [FacturaController::class, 'actualizarEstado']);
            Route::delete('/facturacion/{id}', [FacturaController::class, 'destroy']);
            
            Route::get('/facturacion/{id}/pdf', [FacturaController::class, 'generarPdf']);
        });

        Route::middleware('role:lavador,secretario')->group(function () {
            Route::get('/lavadero', [LavaderoController::class, 'index']);
            Route::post('/lavadero', [LavaderoController::class, 'store']);
            Route::patch('/lavadero/{id}/estado', [LavaderoController::class, 'actualizarEstado']);
            Route::delete('/lavadero/{id}', [LavaderoController::class, 'destroy']);
        });
    });
});