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
    // Obtener todos los proyectos ordenados de forma descendente
    $projects = Project::orderBy('start_date', 'desc')->paginate(7); // 7 proyectos por página

    // Si la solicitud es AJAX, devuelve los proyectos en formato JSON
    if ($request->ajax()) {
        return response()->json($projects);
    }

    // Esto es para marcar el menú como activo
    $activeTab = 'proyectos';
    // Devuelve la vista y pasa la lista de proyectos
    return view('projects', [
        'projects' => $projects,
        'activeTab' => $activeTab
    ]);
}

public function indexAll(Request $request)
{
    // Obtener todos los proyectos ordenados de forma descendente
    $projects = Project::orderBy('start_date', 'desc')->get(); // Obtener todos sin paginar

    // Si la solicitud es AJAX, devuelve los proyectos en formato JSON
    if ($request->ajax()) {
        return response()->json($projects);
    }

    // Esto es para marcar el menú como activo (opcional)
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
