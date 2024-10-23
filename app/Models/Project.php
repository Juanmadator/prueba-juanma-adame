<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    use HasFactory;

    //los atributos que tiene, el nombre del que lo crea, fecha de inicio y fin y la descripcion
    protected $fillable = [
        'name',
        'user_name',
        'start_date',
        'end_date',
        'description',
    ];


    /**
     * Relación: Un proyecto pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_name', 'name'); // Relación con el nombre del usuario
    }

    /**
     * Relación: Un proyecto tiene muchas tareas.
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'project_id');
    }
}
