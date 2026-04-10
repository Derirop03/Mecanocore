<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reparacion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reparaciones';

    protected $fillable = [
        'vehiculo_id',
        'mecanico_asignado',
        'descripcion_falla',
        'estado',
        'precio'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class)->withTrashed();
    }
}