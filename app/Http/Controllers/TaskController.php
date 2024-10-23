<?php

namespace App\Http\Controllers;

use App;
use App\Models\Task;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

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



    public function obtenerTareas(Request $request)
    {
        // Validación de datos
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'title' => 'required|string',
            'user_name' => 'required|string',
        ]);

        // Asignación de variables
        $startDate = Carbon::parse($request->input('start_date')); // Conversión a Carbon
        $endDate = Carbon::parse($request->input('end_date'));
        $title = $request->input('title');
        $userName = $request->input('user_name');

        // Consulta a la base de datos
        $tasks = \DB::table('tasks')
            ->where('title', $title)
            ->where('user_name', $userName)
            ->where('start_time', '>=', $startDate)
            ->where('start_time', '<=', $endDate)
            ->get();

       

        // Generar PDF
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('tareas', [
            'tasks' => $tasks,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'firstTitle' => $title,
            'userName'=>$userName
        ]);

    return $pdf->stream('tasks_report.pdf');
    }



    public function getUserTasks($user)
{
    // Obtener las tareas del usuario en orden cronológico
    $tasks = Task::where('user_name', $user)->get(['title', 'start_time', 'end_time', 'user_name', 'description']);

    // Devolver las tareas en formato JSON
    return response()->json($tasks);
}
}
