<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        Task::create([
            'title' => 'Tarea 1',
            'user_name' => 'Juan',
            'project_id' => 1, // Asegúrate de que el ID del proyecto exista
            'start_time' => now(),
            'end_time' => now()->addHours(5),
            'description' => 'Descripción de la Tarea 1',
        ]);

        Task::create([
            'title' => 'Tarea 2',
            'user_name' => 'Maria',
            'project_id' => 2,
            'start_time' => now(),
            'end_time' => now()->addHours(3),
            'description' => 'Descripción de la Tarea 2',
        ]);

        // Añade más tareas según sea necesario
    }
}
