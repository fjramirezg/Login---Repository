<?php

namespace App\Models;

use Database\Seeders\Cliente;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class UserMod extends Authenticatable

{
    use HasApiTokens, HasRoles, Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password',];

    // Relacion HasMany - 1 Usuario Tiene muchos clientes.
    public function clients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Cliente::class, 'user_id');
    }

    protected $casts = [];

    // public $timestamps = false;
    protected $table = 'users';
}
