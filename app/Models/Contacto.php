<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;
    protected $fillabel = ['con_nombre','con_apellido','con_telefono','con_email','con_descripcion'];

}
