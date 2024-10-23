<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Schema;

class Task extends Model
{

    use HasFactory;

    protected $fillable = [
        'title',
        'user_name',
        'project_id',
        'start_time',
        'end_time',
        'description', // Añadir el campo description aquí
    ];
    //
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Campo id
            $table->string('user_name'); // Nombre del usuario
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Referencia al proyecto
            $table->dateTime('start_time'); // Hora de inicio
            $table->dateTime('end_time'); // Hora de fin
            $table->string('title'); // Añadir campo para el título
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }


    /**
     * Relación: Una tarea pertenece a un proyecto.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relación: Una tarea pertenece a un usuario (a través del proyecto).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_name', 'name'); // Relación con el nombre del usuario
    }

}
