<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'user_id']; // Agregar 'user_id' a los campos fillables

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Relación inversa con el modelo User
    }
}
