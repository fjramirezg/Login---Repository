<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserMod extends Authenticatable
{
    use HasApiTokens, Notifiable;


    protected $fillable = ['user_id', 'name', 'email', 'password', ];
    protected $hidden = ['password',];


    protected $casts = [];
    public $timestamps = false;


}
