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
        'first_name',
        'last_name',
        'phone_number',
        'date_of_birth',
        'profile_image',
        'status',
        'last_login',
    ];

    /**
     * Ocultar atributos sensibles en la serialización.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casters de atributos.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'last_login' => 'datetime',
    ];
}
