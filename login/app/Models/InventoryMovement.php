<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    use HasFactory;

    protected $table = 'inventory_movements';

    protected $fillable = [
        'producto_id',
        'tipo_movimiento',
        'cantidad',
        'fecha',
    ];

    /**
     * Relación Muchos a Uno con Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id');
    }
}
