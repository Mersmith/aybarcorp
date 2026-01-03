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
        Schema::create('evidencia_pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unidad_negocio_id')->constrained('unidad_negocios')->cascadeOnDelete();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
            $table->foreignId('cliente_id')->nullable()->constrained('users')->nullOnDelete(); //user_id

            $table->string('path');
            $table->string('url');
            $table->string('extension');

            $table->string('numero_operacion')->nullable();
            $table->string('banco')->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->date('fecha')->nullable();

            $table->text('observacion')->nullable();
            $table->foreignId('estado_evidencia_pago_id')->default(1)->constrained('estado_evidencia_pagos')->onDelete('restrict');

            $table->string('codigo_cliente')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('nombre_proyecto')->nullable();
            $table->string('etapa')->nullable();
            $table->string('manzana')->nullable();
            $table->string('lote')->nullable();
            $table->string('codigo_cuota')->nullable();
            $table->string('numero_cuota')->nullable();
            $table->string('transaccion_id')->nullable(); //idcobranzas
            $table->string('lote_completo')->nullable();

            $table->foreignId('gestor_id')->nullable()->constrained('users')->nullOnDelete();

            //SUPERVISOR
            $table->foreignId('usuario_valida_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('fecha_validacion')->nullable();

            //AUDITORIA
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencia_pagos');
    }
};
