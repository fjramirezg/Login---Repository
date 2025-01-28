<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'venta_id',
        'monto',
        'metodo_pago',
        'fecha',
    ];

    /**
     * Relación Muchos a Uno con Sale
     */
    public function sale(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sale::class, 'venta_id');
    }
}
