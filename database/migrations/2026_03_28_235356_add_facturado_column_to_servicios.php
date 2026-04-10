<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->boolean('facturado')->default(false);
        });

        Schema::table('lavados', function (Blueprint $table) {
            $table->boolean('facturado')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('reparaciones', function (Blueprint $table) {
            $table->dropColumn('facturado');
        });

        Schema::table('lavados', function (Blueprint $table) {
            $table->dropColumn('facturado');
        });
    }
};