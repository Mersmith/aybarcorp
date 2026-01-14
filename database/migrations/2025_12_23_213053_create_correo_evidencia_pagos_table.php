<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('correo_evidencia_pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('solicitud_evidencia_pago_id')
                ->constrained('solicitud_evidencia_pagos')
                ->cascadeOnDelete();

            $table->text('mensaje')->nullable();
            $table->timestamp('enviado_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('correo_evidencia_pagos');
    }
};
