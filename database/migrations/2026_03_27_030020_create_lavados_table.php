<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lavados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            $table->string('tipo_servicio');
            $table->string('operario')->default('Sin asignar');
            $table->string('estado')->default('Espera');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lavados');
    }
};