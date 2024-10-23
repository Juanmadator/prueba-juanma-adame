<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'admin' => 'boolean',
    ];


     /**
     * Relación: Un usuario tiene muchos proyectos.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'user_name', 'name'); // Relación con el nombre del usuario
    }

    /**
     * Relación: Un usuario tiene muchas tareas a través de los proyectos.
     */
    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Project::class, 'user_name', 'project_id', 'name', 'id');
    }
}
