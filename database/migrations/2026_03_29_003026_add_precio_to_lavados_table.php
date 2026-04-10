<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lavados', function (Blueprint $table) {
            $table->integer('precio')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('lavados', function (Blueprint $table) {
            $table->dropColumn('precio');
        });
    }
};