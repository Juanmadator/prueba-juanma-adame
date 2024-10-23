@extends('layouts.app')

@section('content')
<div class="card w-50 mt-3 mx-auto">
    <div class="card-header">
        <h5 class="card-title">Gestión de Usuarios</h5>
    </div>
    <div class="card-body">
        <form id="userForm">
            @csrf
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

            <button type="submit" class="btn btn-primary" id="submitButton">Crear Usuario</button>
        </form>

        <h5 class="mt-4">Lista de Usuarios</h5>
        <ul id="userList" class="list-group">
            <!-- La lista de usuarios se llenará aquí mediante AJAX -->
        </ul>
    </div>
</div>

@section('scripts')
<script>
    // Cargar la lista de usuarios al inicio
    function loadUsers() {
        $.ajax({
            url: '/usuarios',
            method: 'GET',
            success: function(data) {
                $('#userList').empty(); // Limpiar la lista existente
                data.forEach(function(user) {
                    $('#userList').append('<li class="list-group-item">' + user.name + ' (' + user.email + ')</li>');
                });
            },
            error: function(err) {
                console.error('Error al cargar usuarios:', err);
            }
        });
    }

    $(document).ready(function() {
        loadUsers(); // Cargar usuarios al cargar la página

        // Manejo del envío del formulario
        $('#userForm').on('submit', function(event) {
            event.preventDefault(); // Evitar que el formulario se envíe de forma normal

            $.ajax({
                url: '/users', // Ruta de almacenamiento de usuarios
                method: 'POST',
                data: $(this).serialize(), // Serializa los datos del formulario
                success: function(response) {
                    // Mostrar un mensaje de éxito o hacer algo después de crear el usuario
                    alert('Usuario creado exitosamente: ' + response.name);
                    loadUsers(); // Recargar la lista de usuarios
                    $('#userForm')[0].reset(); // Limpiar el formulario
                },
                error: function(xhr) {
                    // Manejar errores
                    alert('Error al crear usuario: ' + xhr.responseJSON.message);
                }
            });
        });
    });
</script>
@endsection

@endsection
