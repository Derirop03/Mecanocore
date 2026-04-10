<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factura extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vehiculo_id',
        'concepto',
        'total',
        'estado'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class)->withTrashed();
    }
}