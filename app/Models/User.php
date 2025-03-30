<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    public function juegos()
    {
        return $this->hasMany(Juego::class);
    }

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'remember_token',
        'security_question_1',
        'security_answer_1',
        'security_question_2',
        'security_answer_2',
        'token_expiration',
        'verification_code', // Agregar verification_code
        'verification_expires_at', // Agregar verification_expires_at
        'session_id',
        'juegos_permissions',
        'materias_permissions',
        'proyectos_permissions',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'verification_expires_at' => 'datetime', // Agregar verification_expires_at
            'token_expiration' => 'datetime', // agregar token_expiration
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
