<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/ping', function () {
    return response()->json([
        'success' => true,
        'mensaje' => '¡La API de MecanoCore está conectada y funcionando perfectamente!'
    ]);
});

