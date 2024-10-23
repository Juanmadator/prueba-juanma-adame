<!-- resources/views/projects_list.blade.php -->
@extends('layouts.app')


@section('content')

<div class="row w-75  mt-3 mx-auto">

    <div class="col-3 ml-5">
        <div id="projectsList">
            <h3>Listado de Proyectos</h3>
                <a href="#" id="proyectos" class="nav-link" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="far fa-circle nav-icon"></i>
                    <p id="myButton" >Añadir proyecto</p>
                </a>

                <a href="#" id="proyectos" class="nav-link" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="far fa-circle nav-icon"></i>
                    <p id="myButton" >Generar PDF</p>
                </a>

            <ul id="projectItems" class="list-group">

            </ul>
        </div>
    </div>
    <div class="col-8">
        <h3>Calendario de Tareas</h3>
        <div id="calendar" class="zindex-2" data-drop="true"></div>
    </div>
</div>

<div id="taskModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Nueva Tarea</h5>
            <span class="close" onclick="closeTaskModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="taskForm"> <!-- Aquí se previene el envío del formulario -->
                <p id="startTime"></p>
                <p id="endTime"></p>
                @csrf
                {{--  <input type="hidden" name="_token" value="{{ csrf_token() }}">  --}}
                <textarea id="taskDescription" class="form-control" rows="3" placeholder="Escribe tu tarea aquí..." required></textarea>
                <button type="submit" id="saveTask">Guardar Tarea</button> <!-- Cambia el tipo a 'submit' -->
            </form>
        </div>
        <div class="modal-footer">
            <button onclick="closeTaskModal()">Cerrar</button>
        </div>
    </div>
</div>


@endsection
