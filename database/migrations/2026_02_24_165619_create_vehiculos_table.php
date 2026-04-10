<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('vehiculos', function (Blueprint $table) {
        $table->id();
        $table->string('placa')->unique();
        $table->string('marca');
        $table->string('modelo');
        $table->integer('anio');
        $table->string('cliente');
        $table->string('estado')->default('En Diagnóstico');
        $table->timestamps();
    });
}
    
};
