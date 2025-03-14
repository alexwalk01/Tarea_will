<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
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


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
/**
     * Obtener el identificador único de JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Retorna el identificador único del usuario (id_usuario)
    }

    /**
     * Obtener los "claims" personalizados para el JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];  // Puedes añadir claims personalizados si es necesario
    }

}
