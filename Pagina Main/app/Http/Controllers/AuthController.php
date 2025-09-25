<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Customer;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user()->load('role');
            
            if ($user->isAdmin()) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('catalog');
            }
        }

        return back()->withErrors(['email' => 'Credenciales inválidas'])->withInput();
    }

    public function showRegister()
    {
        return view('registrar');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'id_rol' => 2,
        ]);

        Customer::create([
            'documento' => 'USR-' . $user->id,
            'nombre' => $user->name,
            'correo' => $user->email,
            'telefono' => $data['telefono'],
            'direccion' => null,
        ]);

        return redirect()->route('login')->with('success', 'Usuario registrado exitosamente. Inicia sesión.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}


