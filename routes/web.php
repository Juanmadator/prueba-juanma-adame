<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta principal que redirige al layout
Route::get('/', function () {
    return redirect()->route('usuarios.index'); // Redirige a la ruta de app
});


//para controlar el acceso a rutas que no existen
Route::fallback(function () {
    return redirect('/');
});

// Ruta para la vista del dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para el layout de la aplicación
Route::get('/users', function () {
    $user = Auth::user(); // Obtiene el usuario autenticado
    return view('users', ['user' => $user]); // Pasa el usuario a la vista
})->name('app');

Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index'); // Obtener la lista de usuarios
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store'); // Crear un nuevo usuario
Route::put('/usuarios/{email}', [UserController::class, 'update'])->name('usuarios.update'); // Actualizar un usuario
Route::delete('/usuarios/{email}', [UserController::class, 'destroy'])->name('usuarios.destroy'); // Eliminar un usuario

// Rutas para la gestión de proyectos

Route::get('/proyectos', [ProjectController::class, 'index'])->name('proyectos.index');
Route::get('/proyectos/all', [ProjectController::class, 'indexAll'])->name('proyectos.all');
Route::post('/proyectos', [ProjectController::class, 'store'])->name('proyectos.store'); // Ruta para crear un proyecto
Route::resource('projects', ProjectController::class); // API resource para proyectos


//Ruta para crear la tarea de un proyecto
Route::post('/tasks',[TaskController::class,'store']);
Route::post('/tasks/obtener', [TaskController::class, 'obtenerTareas'])->name('tasks.obtener');


//Para mostrar las tareas de un usuario en concreto
Route::get('/tasks/{user}', [TaskController::class, 'getUserTasks'])->name('tasks.user');



require __DIR__.'/auth.php';
