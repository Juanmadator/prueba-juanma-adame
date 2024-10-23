<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    // Esta función devuelve la vista de gestión de usuarios y la lista de todos los usuarios
    public function index(Request $request)
    {
        // Llamamos al método estático para obtener todos los usuarios
        $users = User::all();

        if ($request->ajax()) {
            return response()->json($users); // Devuelve los usuarios en formato JSON
        }

        $activeTab = 'usuarios';
        // Devuelve la vista y pasa la lista de usuarios
        return view('users', ['users' => $users,'activeTab' => $activeTab]); // Asegúrate de que esta vista existe
    }

    // Método para almacenar y crear un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'admin' => $request->input('admin', 0) == '1' ? 1 : 0,
        ]);

        return response()->json($user, 201);
    }

    // Método para eliminar un usuario
    public function destroy($email)
    {
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->delete(); // Elimina el usuario
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } else {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
    }

    // Método para actualizar un usuario
    public function update(Request $request, $email)
    {
        $user = User::where('email', $email)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6', // No es obligatorio cambiar la contraseña
            'admin' => 'nullable|boolean',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->admin = $request->has('admin');
        $user->save();

        return response()->json(['message' => 'Usuario actualizado exitosamente']);
    }
}
