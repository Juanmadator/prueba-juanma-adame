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

// Ruta para la vista del dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Ruta para el layout de la aplicación
Route::get('/app', function () {
    $user = Auth::user(); // Obtiene el usuario autenticado
    return view('users', ['user' => $user]); // Pasa el usuario a la vista
})->name('app');

// Rutas para la gestión de usuarios
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store'); // Ruta para crear un usuario
Route::apiResource('users', UserController::class); // API resource para usuarios
// Route::put('/users/{email}', [UserController::class, 'update'])->name('users.update');

// Rutas para la gestión de proyectos

Route::get('/proyectos', [ProjectController::class, 'index'])->name('proyectos.index');
Route::post('/proyectos', [ProjectController::class, 'store'])->name('proyectos.store'); // Ruta para crear un proyecto
Route::resource('projects', ProjectController::class); // API resource para proyectos


//Ruta para crear la tarea de un proyecto
Route::post('/tasks',[TaskController::class,'store']);

//Para mostrar las tareas de un usuario en concreto
Route::get('/tasks/{user}', [TaskController::class, 'getUserTasks'])->name('tasks.user');


// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
