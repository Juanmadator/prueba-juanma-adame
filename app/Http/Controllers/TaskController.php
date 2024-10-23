<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function store(Request $request)
    {
        //debe tener la hora de incio y fin, el usuario y la descripcion que la he llamado task
        $request->validate([
            'title' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'description' => 'required|string|max:255',
        ]);

        // Crear la tarea
        Task::create([
            'title' => $request->title,
            'user_name' => Auth::user()->name,
            'project_id' => $request->project_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Tarea guardada con éxito']);
    }


    public function getUserTasks($user)
{
    // Obtener las tareas del usuario en orden cronológico
    $tasks = Task::where('user_name', $user)->get(['title', 'start_time', 'end_time', 'user_name', 'description']);

    // Devolver las tareas en formato JSON
    return response()->json($tasks);
}
}
