<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    use HasFactory;

    protected $table = 'juegos'; // Asegúrate de que el nombre coincida con tu tabla en la base de datos

    protected $fillable = ['nombre', 'descripcion', 'categoria_id'];
}
