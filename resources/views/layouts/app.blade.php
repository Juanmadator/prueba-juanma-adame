<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Plantilla AdminLTE 3 </title>
  <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script  src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>


</head>

<style>

.modal {
    display: none; /* Oculto por defecto */
    position: fixed; /* Posicionamiento fijo */
    z-index: 1; /* Sobre otras capas */
    left: 0;
    top: 0;
    width: 100%; /* Ancho completo */
    height: 100%; /* Alto completo */
    overflow: auto; /* Habilita el desplazamiento si es necesario */
    background-color: rgb(0,0,0); /* Color de fondo */
    background-color: rgba(0,0,0,0.4); /* Color de fondo con opacidad */
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* 15% desde la parte superior y centrado */
    padding: 20px;
    border: 1px solid #888;
    width: 60%; /* Ancho del modal */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}


</style>

<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Navbar links -->
    @if(!Auth::check())
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('login') }}" class="nav-link">Login</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('register') }}" class="nav-link">Registrarse</a>
        </li>
    </ul>
    @elseif(Auth::check())
    <ul class="navbar-nav">
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('profile.edit') }}" class="nav-link">Perfil</a>
        </li>
        <li class="nav-item d-none mr-1 d-sm-inline-block">
            <form method="POST" class="w-100" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link bg-transparent border-0 d-inline">
                   Salir
                </button>
            </form>
        </li>
    </ul>
    @endif

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm ">
        <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    @if(Auth::check())
    <div class="w-full h-full px-4 w-100 py-2">
        <p class="text-right m-0 ">
            <span class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center">
                {{ Auth::user()->name }}
            </span>
        </p>
    </div>
    @endif
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary ">
    <a href="{{route('app')}}" class="brand-link w-100">
      <img src="https://solucionesinformaticasmj.com/wp-content/uploads/2024/04/logo-simj-24.svg" alt="AdminLTE Logo" class="brand-image">
      <span class="brand-text font-weight-light">SI MJ</span>
    </a>

    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview menu-open">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inicio</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{ route('usuarios.index') }}" id="usuarios" class="nav-link {{isset($activeTab) && $activeTab === 'usuarios' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Usuarios</p>
                </a>
            </li>

            @if(Auth::check() && Auth::user()->admin == "1")
            <li class="nav-item">
                <a href="{{ route('proyectos.index') }}" id="control-proyectos" class="nav-link {{isset($activeTab) && $activeTab === 'proyectos' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Control de proyectos</p>
                </a>
            </li>
            @endif
          <!-- Modal -->
          {{--  <div id="myCustomModal" >
            <div>
                <h5>Título del Modal</h5>
                <p>Contenido del modal personalizado.</p>
                <button id="closeModal" class="btn btn-secondary">Cerrar</button>
            </div>
        </div>  --}}


        <div id="myCustomModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background-color: rgba(0, 0, 0, 0.5); z-index: 1000;">
            <div class="modal-content"  style="background: white; margin: auto; padding: 20px; width: 300px; position: relative; top: 50%; transform: translateY(-50%);">
                <h5>Añadir Nuevo Proyecto</h5>
                <form id="projectForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Nombre del Proyecto</label>
                        <input type="text" class="form-control" id="projectName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="startDate" name="start_date">
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Proyecto</button>
                </form>

            </div>
        </div>

            </ul>
          </li>
        </ul>
      </nav>
    </div>
  </aside>


<!--DEBE IR AQUÍ CADA COMPONENTE-->

@yield('content') <!-- Aquí se insertará el contenido específico -->



  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>



  <footer class="main-footer">
    <div class="float-right d-none d-sm-inline">
        Prueba técnica 2024
    </div>
    <strong>Copyright &copy; 2024 <a href="#">Juan Manuel Adame Torronteras</a>.</strong>
  </footer>
</div>




</body>

<script>
    var Calendar = FullCalendar.Calendar;
    var Draggable = FullCalendar.Draggable;


    var containerEl = document.getElementById('projectItems');
    var calendarEl = document.getElementById('calendar');

    var calendar,projectId,formattedStart,formattedEnd,title;

    var username="{{Auth::check() ? Auth::user()->name: ''}}"

    $(document).ready(function () {
        loadUsers();
        loadProjects(); // Llamar a la función para cargar proyectos
        enableDraggable();
        cargarCalendario(); // Asegúrate de incluir el punto y coma aquí

        // Este evento se encarga tanto de crear como de editar el usuario
        $('#userForm').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize(); // Serializamos los datos del formulario
            let email = $(this).attr('data-email'); // Obtenemos el email almacenado (si es edición)
            if (email) {
                updateUser(email, formData);
            } else {
                createUser(formData);
            }
        });

        // Abrir el modal al hacer clic en el botón
        $('#myButton').click(function () {
            $('#myCustomModal').show();
        });

        // Control del menú de proyectos
        $('#control-proyectos').click(function (e) {
            e.stopPropagation(); // Detiene la propagación del evento
            $(this).toggleClass('active'); // Añade o quita la clase active
        });

        // Cerrar el modal
        $('#closeModal').click(function () {
            $('#myCustomModal').hide();
        });

        const taskForm = document.getElementById('taskForm');

        if(taskForm){
            taskForm.addEventListener('submit', function (event) {
                event.preventDefault(); // Evitar el envío del formulario convencional
                saveTask(); // Llamar a tu función para guardar la tarea
            });
        }else{
            console.log("no existe")
        }

    });

    // Función para abrir el modal de tarea
    function openTaskModal(startDate, endDate) {
        // Formatear las fechas
        formattedStart = startDate.toLocaleString('es-ES');
        formattedEnd = endDate.toLocaleString('es-ES');

        // Mostrar las horas en el modal
        document.getElementById('startTime').innerText = "Hora de inicio: " + formattedStart;
        document.getElementById('endTime').innerText = "Hora de fin: " + formattedEnd;

        // Mostrar el modal
        document.getElementById('taskModal').style.display = 'block';
    }

    // Función para cerrar el modal de tarea
    function closeTaskModal() {
        document.getElementById('taskModal').style.display = 'none';
    }

    function parseDate(dateString) {
        // Extraer los componentes de la fecha y hora
        const [datePart, timePart] = dateString.split(', ');
        const [day, month, year] = datePart.split('/').map(Number);
        const [hours, minutes, seconds] = timePart.split(':').map(Number);

        // Crear un nuevo objeto Date
        return new Date(year, month - 1, day, hours, minutes, seconds);
    }

    // Función para formatear la fecha en el formato requerido por MySQL
    function formatToMySQLDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Meses en JavaScript son 0-indexados
        const day = String(date.getDate()).padStart(2, '0');
        const hours = String(date.getHours()).padStart(2, '0');
        const minutes = String(date.getMinutes()).padStart(2, '0');
        const seconds = String(date.getSeconds()).padStart(2, '0');
        return `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    }

    // Función para guardar la tarea
    function saveTask() {

        const taskDescription = document.getElementById('taskDescription').value;

        // Obtener el token CSRF y verificar que no sea nulo
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (!csrfTokenMeta) {
            console.error('No se encontró el token CSRF en el meta tag.');
            return; // Salir de la función si no se encuentra el token
        }

        const startDate = parseDate(formattedStart);
        const endDate = parseDate(formattedEnd);

        // Formatear las fechas para MySQL
        const startDateFormatted = formatToMySQLDate(startDate);
        const endDateFormatted = formatToMySQLDate(endDate);

        const formData = {
            project_id: projectId, // Asegúrate de que projectId esté definido en tu contexto
            start_time: startDateFormatted,  // Usar la fecha formateada
            end_time: endDateFormatted,      // Usar la fecha formateada
            title:title,
            description: taskDescription,
            _token: csrfTokenMeta.content // Incluir el token CSRF
        };


        $.ajax({
            url: '/tasks',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(formData),
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: response.message
                });

                //cerramos el modal
                closeTaskModal();
                loadProjects();
                clearCalendar()
                loadUserTasks(username);
                document.getElementById('taskDescription').value = ''; // Limpiar el textarea después de guardar
            },
            error: function (xhr) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: xhr.responseJSON.message // Mensaje de error del servidor
                });
                //cerramos el modal
                closeTaskModal()
            }
        });
    }


    // Función para cargar las tareas del usuario seleccionado
    function loadUserTasks(userName) {

        $.ajax({
            url: '/tasks/' + userName,
            type: 'GET',
            success: function(tasks) {
                // Limpiar el calendario antes de agregar nuevas tareas
                clearCalendar();

                // Recorrer las tareas y agregarlas al calendario
                tasks.forEach(function(task) {
                    const start = new Date(task.start_time);
                    const end = new Date(task.end_time);

                    // Definir el evento para FullCalendar
                    const calendarEvent = {
                        title: task.title,
                        start: start,
                        end: end,
                        user_name: task.user_name,
                        description: task.description

                    };

                    // Agregar al calendario utilizando FullCalendar v5
                    addEventToCalendar(calendarEvent);
                });
            },
            error: function(xhr) {
                console.error("Error al cargar las tareas: ", xhr.responseText);
            }
        });
    }


    function addEventToCalendar(event) {
        // Asegúrate de que el calendario esté accesible globalmente
        calendar.addEvent(event);
    }


    function clearCalendar() {
           calendar.removeAllEvents(); // Elimina todos los eventos actuales
    }

    // Función para cargar el calendario
    function cargarCalendario() {
         calendar = new Calendar(calendarEl, {
            initialView: 'timeGridDay',
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar
            drop: function (info) {
                // is the "remove after drop" checkbox checked?
                // if so, remove the element from the "Draggable Events" list
                title = info.draggedEl.getAttribute('data-project');
                projectId = info.draggedEl.getAttribute('id');
                var startDate = info.date; // Fecha y hora en que se soltó el evento
                var durationMinutes = 60; // Duración del evento en minutos

                // Calcular la hora de fin
                var endDate = new Date(startDate.getTime() + durationMinutes * 60000); // Agregar minutos a la hora de inicio

                openTaskModal(startDate, endDate);
            }
        });

        calendar.render();

        loadUserTasks(username);

    }

    // Función para habilitar la funcionalidad de arrastrar
    function enableDraggable() {
        new Draggable(containerEl, {
            itemSelector: '.draggable',
            eventData: function (eventEl) {
                return {
                    title: eventEl.innerText
                };
            }
        });
    }

    // Función para cargar la lista de proyectos
    function loadProjects() {
        $.ajax({
            url: "{{ route('projects.index') }}",
            type: "GET",
            success: function (projects) {
                $('#projectItems').empty();
                $('#projectItems').append(`
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col"><b>Nombre</b></div>
                            <div class="col"><b>Fecha</b></div>
                            <div class="col"><b>Creador</b></div>
                        </div>
                    </li>
                `);
                projects.forEach(function (project) {
                    $('#projectItems').append(`
                        <li class="list-group-item draggable" data-project='${project.name}' draggable="true" id="${project.id}">
                            <div class="row">
                                <div class="col">${project.name}</div>
                                <div class="col">${project.start_date}</div>
                                <div class="col">${project.user_name}</div>
                            </div>
                        </li>
                    `);
                });
            },
            error: function (xhr) {
                console.error('Error al cargar proyectos:', xhr);
            }
        });
    }

    // Función para cargar la lista de usuarios
    function loadUsers() {
        $.ajax({
            url: "{{ route('users.index') }}", // Ruta para obtener usuarios
            type: "GET",
            success: function (data) {
                let userList = $('#userList');
                userList.empty(); // Limpiamos la lista antes de cargar de nuevo

                $.each(data, function (index, user) {
                    userList.append(`
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${user.name} (${user.email}) ${user.admin == 1 ? 'Es administrador' : 'No es administrador'}
                            <div>
                                <button class="btn btn-primary" onclick="editUser('${user.email}', '${user.name}', ${user.admin})">Editar</button>
                                <button class="btn btn-danger" onclick="deleteUser(${user.id})">Eliminar</button>
                            </div>
                        </li>
                    `);
                });
            }
        });
    }

    // Función para crear usuario
    function createUser(formData) {
        $.ajax({
            url: "{{ route('users.store') }}", // Ruta para crear usuario
            type: "POST",
            data: formData,
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: `Usuario creado`
                });
                $('#userForm')[0].reset(); // Limpiar el formulario
                $('#submitButton').text('Crear Usuario'); // Aseguramos que el botón vuelva a "Crear Usuario"
                $('#userForm').removeAttr('data-email'); // Limpiamos el atributo de email para no mantener el modo edición
                loadUsers(); // Recargar la lista de usuarios
            },
            error: function (xhr) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: xhr.responseJSON.message // Mensaje de error del servidor
                });
            }
        });
    }

    // Función para editar usuario
    function editUser(email, name, admin) {
        $('#userForm').attr('data-email', email); // Guardamos el email para identificar al usuario
        $('#userName').val(name);
        $('#userAdmin').prop('checked', admin === 1); // Comprobar si es admin
        $('#submitButton').text('Actualizar Usuario'); // Cambiamos el texto del botón a "Actualizar Usuario"
        $('#myCustomModal').show(); // Mostrar el modal para editar
    }

    // Función para actualizar usuario
    function updateUser(email, formData) {
        $.ajax({
            url: `{{ url('users') }}/${email}`,
            type: "PUT",
            data: formData,
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: `Usuario actualizado`
                });
                $('#userForm')[0].reset(); // Limpiar el formulario
                $('#submitButton').text('Crear Usuario'); // Aseguramos que el botón vuelva a "Crear Usuario"
                $('#userForm').removeAttr('data-email'); // Limpiamos el atributo de email para no mantener el modo edición
                loadUsers(); // Recargar la lista de usuarios
            },
            error: function (xhr) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: xhr.responseJSON.message // Mensaje de error del servidor
                });
            }
        });
    }

    // Función para eliminar usuario con el id
    function deleteUser(id) {
        $.ajax({
            url: `{{ url('users') }}/${id}`,
            type: "DELETE",
            success: function (response) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: `Usuario eliminado`
                });
                loadUsers(); // Recargar la lista de usuarios
            },
            error: function (xhr) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: xhr.responseJSON.message // Mensaje de error del servidor
                });
            }
        });
    }

</script>

</html>
