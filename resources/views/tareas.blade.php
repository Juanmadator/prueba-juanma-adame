<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Tareas</title>
    <style>
        body {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #201dca;
            color: white;
        }
        .titulo {
            text-align: center;
            color: #3532d1;
            text-transform: uppercase;
            margin: 20px 0;
            font-size: 1.2em;
            border-bottom: 2px solid gray; 
        }
        .titulo-1 {
            text-transform: uppercase;
            font-size: 1.1em;
            margin: 10px 0;
        }
        .soluciones {
            display: flex;
            flex-direction: row;
            margin-bottom: 20px;
        }
        .tablas {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        img {
            width: 200px;
            height: auto;
        }
        .total-container {
            border: 1px solid #3532d1;
            padding: 10px;
            margin-top: 20px;
            background-color: #f9f9f9;
        }

        .tablitas{
            width: 200px;
        }
    </style>
</head>
<body>

<div class="soluciones">
    <div class="icono">
        <img src="https://solucionesinformaticasmj.com/wp-content/uploads/2024/04/logo-simj-24.svg" alt="Soluciones Logo" class="brand-image" style="width: 200px; height: auto;">
    </div>
    <div>
        <h3 class="titulo-1">1- Soluciones informáticas ms s.c.a</h3>
        <div class="tablas">
            <table class="tablitas">
                <tr>
                    <th>Desde fecha</th>
                    <td>{{$startDate}}</td>
                </tr>
                <tr>
                    <th>Hasta fecha</th>
                    <td>{{$endDate}}</td>
                </tr>
            </table>

            <table class="tablitas">
                <tr>
                    <th>Proyecto</th>
                    <td>-</td>
                </tr>
                <tr>
                    <th>Usuario</th>
                    <td>{{$userName}}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<h3 class="titulo">INFORME DE TAREAS REALIZADAS</h3>
@if(count($tasks) > 0)
    <h3 class="titulo-1">{{$firstTitle}}</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Minutos</th>
                <th>Usuario</th>
                <th>Tarea Realizada</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalMinutes = 0; // Inicializa la variable para sumar los minutos
            @endphp
            @foreach ($tasks as $task)
                @php
                    $minutes = \Carbon\Carbon::parse($task->start_time)->diffInMinutes(\Carbon\Carbon::parse($task->end_time));
                    $totalMinutes += $minutes; // Suma los minutos al total
                @endphp
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->start_time }}</td>
                    <td>{{ $task->end_time }}</td>
                    <td>{{ $minutes }}</td>
                    <td>{{ $task->user_name }}</td>
                    <td></td> <!-- La columna de tarea realizada siempre estará en blanco -->
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Mostrar la suma total de minutos -->
    <div class="total-container">
        <strong>TOTAL MINS: {{ $totalMinutes }}</strong>
    </div>

@else
    <p>No se encontraron tareas.</p>
@endif

</body>
</html>
