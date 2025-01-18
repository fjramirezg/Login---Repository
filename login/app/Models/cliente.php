<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar de forma masiva.
     */
    protected $fillable = ['name', 'email', 'phone','address'];
}
