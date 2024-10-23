<!-- resources/views/projects_list.blade.php -->
@extends('layouts.app')


@section('content')

<div class="row w-75  mt-3 mx-auto">

    <div class="col-3 ml-5">
        <div id="projectsList">
            <h3>Listado de Proyectos</h3>


            @if (Auth::check() && Auth::user()->admin == 1)
                <a href="#" id="proyectos" class="nav-link" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="far fa-circle nav-icon"></i>
                    <p id="myButton" >Añadir proyecto</p>
                </a>
                @else
                <a href="#" id="proyectosError" class="nav-link" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="far fa-circle nav-icon"></i>
                    <p id="miBoton" >Añadir proyecto</p>
                </a>
                @endif

                <a href="#" class="nav-link" id="generatePdfLink" onclick="openPdfModal()">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Generar PDF</p>
                </a>


            <ul id="projectItems" class="list-group">

            </ul>
        </div>
    </div>

    <div class="col-8">
        <form id="usersSelect">
            <div class="mb-3">
                <label for="userSelect2" class="form-label">Seleccionar Usuario</label>
                <select id="userSelect2" class="form-select" name="user" required>

                </select>
            </div>
        </form>

        <div >
            <h3>Calendario de Tareas</h3>
            <div id="calendar" class="calendar" data-drop="true"></div>
        </div>
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

<!-- Modal para Generar PDF -->
<div id="generatePdfModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h5>Generar PDF</h5>
            <span class="close" onclick="closePdfModal()">&times;</span>
        </div>
        <div class="modal-body">
            <form id="pdfForm">
                @csrf
                <div class="form-group">
                    <label for="startDate">Fecha de Inicio:</label>
                    <input type="date" id="initialDate" name="start_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="endDate">Fecha de Fin:</label>
                    <input type="date" id="endDate" name="end_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="projectSelect">Selecciona Proyecto:</label>
                    <select id="projectSelect" name="project_id" class="form-control" required>
                        <option value="">Selecciona un proyecto</option>
                        <!-- Opciones de proyectos se cargarán aquí -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="userSelect">Selecciona Usuario:</label>
                    <select id="userSelect" name="user_id" class="form-control" required>
                        <option value="">Selecciona un usuario</option>
                        <!-- Opciones de usuarios se cargarán aquí -->
                    </select>
                </div>
                <button type="button" id="generatePdfButton" class="btn btn-primary">Generar PDF</button>
                <button type="button" class="btn btn-secondary" onclick="closePdfModal()">Cerrar</button>
            </form>
        </div>
    </div>
</div>





@endsection
