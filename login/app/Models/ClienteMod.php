<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteMod extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'email', 'phone', 'address'];
    protected $table = 'clientes';
    protected $dates = ['deleted_at'];


    // Relacion HasMany - Muchos clientes tienen un usuario
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(UserMod::class, 'user_id');
    }
    public function sales(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Sale::class, 'cliente_id');
    }
}
