<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/sistema');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/sistema');
        }

        return back()->withErrors([
            'username' => 'Las credenciales no coinciden o son incorrectas.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function crearAdmin()
    {
        if (User::where('username', 'admin')->exists()) {
            return redirect('/login')->with('mensaje', 'El administrador ya existe.');
        }

        User::create([
            'name' => 'Administrador',
            'username' => 'admin',
            'email' => 'admin@mecanocore.com',
            'password' => Hash::make('12345678')
        ]);

        return redirect('/login')->with('mensaje', 'Administrador creado con éxito. Usuario: admin | Clave: 12345678');
    }

    public function vistaCambiarClave()
    {
        return view('forzar-cambio');
    }

    public function guardarNuevaClave(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8'
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        return redirect('/sistema')->with('success', '¡Excelente! Tu nueva contraseña ha sido configurada.');
    }
}