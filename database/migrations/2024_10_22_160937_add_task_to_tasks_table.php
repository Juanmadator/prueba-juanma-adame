<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id(); // Campo id
            $table->string('user_name'); // Nombre del usuario
            $table->foreignId('project_id')->constrained()->onDelete('cascade'); // Referencia al proyecto
            $table->dateTime('start_time'); // Hora de inicio
            $table->dateTime('end_time'); // Hora de fin
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tasks'); // Elimina la tabla si se deshace la migración
    }
};
