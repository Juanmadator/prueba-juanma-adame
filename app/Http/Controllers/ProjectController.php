<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Auth;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // Método para devolver la vista de gestión de proyectos y la lista de todos los proyectos
    public function index(Request $request)
    {
        // Obtener todos los proyectos ordenados de forma descente por ejemplo primero el dia 31 luego el día 29 , etc
        $projects = Project::orderBy('updated_at', 'desc')->get();

        // Si la solicitud es AJAX, devuelve los proyectos en formato JSON
        if ($request->ajax()) {
            return response()->json($projects);
        }

        //esto es para marcar el menu como active
        $activeTab = 'proyectos';
        // Devuelve la vista y pasa la lista de proyectos
        return view('projects', [
            'projects' => $projects,
            'activeTab' => $activeTab
        ]);
    }

    // Método para almacenar y crear un nuevo proyecto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'nullable|date',
        ]);

        $project = new Project();
        $project->name = $request->name;
        $project->user_name = Auth::user()->name; // Obtener el nombre del usuario autenticado
        $project->start_date = $request->start_date ?? now()->toDateString(); // Si no se da una fecha, se establece la fecha de hoy
        $project->save();

        return redirect()->route('proyectos.index');
    }


}
