<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'rol' => 'required|in:admin,mecanico,cajero,lavador,secretario',
            'password' => 'required|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'rol' => $request->rol,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/usuarios')->with('success', 'Usuario creado exitosamente.');
    }

    public function resetPassword($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->password = Hash::make('12345678');
        $usuario->save();

        return redirect('/usuarios')->with('success', 'Contraseña restablecida a 12345678 para: ' . $usuario->username);
    }

    public function destroy($id)
    {
        if (Auth::id() == $id) {
            return redirect('/usuarios')->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        User::destroy($id);
        return redirect('/usuarios')->with('success', 'Usuario eliminado del sistema.');
    }
}