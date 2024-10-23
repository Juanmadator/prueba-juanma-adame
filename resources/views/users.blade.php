@extends('layouts.app')

@section('content')
<div class="card w-50 mt-3 mx-auto">
    <div class="card-header">
        <h5 class="card-title">Gestión de Usuarios</h5>
    </div>
    <div class="card-body">
        <form id="userForm">
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control">
                <small id="passwordNotice" class="form-text text-muted">Dejar vacío para no cambiar la contraseña.</small>
            </div>

            <div class="form-group">
                <label for="admin">Administrador</label>
                <input type="checkbox" id="admin" name="admin" value="1">
            </div>

            <button type="submit" class="btn btn-primary" id="buttonUsers">Crear Usuario</button>
        </form>

        <h5 class="mt-4">Lista de Usuarios</h5>
        <ul id="userList" class="list-group">
            <!-- La lista de usuarios se llenará aquí mediante AJAX -->
        </ul>
    </div>
</div>


@endsection
