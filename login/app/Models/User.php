<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * Atributos rellenables para asignación masiva.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * Ocultar atributos sensibles en la serialización.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Casters de atributos.
     *
     * @var array
     */
    protected $casts = [];
    public $timestamps = false;
}
