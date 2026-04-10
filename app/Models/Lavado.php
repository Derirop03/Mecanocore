<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lavado extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vehiculo_id',
        'tipo_servicio',
        'operario',
        'estado',
        'precio'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class)->withTrashed();
    }
}