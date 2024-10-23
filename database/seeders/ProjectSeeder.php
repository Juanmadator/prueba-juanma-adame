<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        Project::create([
            'name' => 'Proyecto A',
            'user_name' => 'Juan',
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'description' => 'Descripción del Proyecto A',
        ]);

        Project::create([
            'name' => 'Proyecto B',
            'user_name' => 'Maria',
            'start_date' => now(),
            'end_date' => now()->addDays(15),
            'description' => 'Descripción del Proyecto B',
        ]);

        // Añade más proyectos según sea necesario
    }
}
