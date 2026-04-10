<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ForzarCambioClave
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si el usuario está logueado y su contraseña coincide con '12345678'
        if (Auth::check() && Hash::check('12345678', Auth::user()->password)) {
            // Lo enviamos a la fuerza a la pantalla de cambio
            return redirect('/forzar-cambio');
        }

        return $next($request);
    }
}