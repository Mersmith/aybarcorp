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
        Schema::create('evidencia_pago_antiguos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unidad_negocio_id')->nullable()->constrained('unidad_negocios')->nullOnDelete();
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete();
            $table->foreignId('cliente_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('imagen_url')->nullable();

            $table->string('operacion_numero')->nullable();
            $table->string('operacion_hora')->nullable();
            $table->string('union')->nullable();
            $table->decimal('cuota_fija', 10, 2)->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->string('pago_de')->nullable();
            $table->string('codigo_cuenta')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->string('moneda')->nullable();
            $table->string('medio_pago')->nullable();
            $table->date('fecha_deposito')->nullable();

            $table->text('observacion')->nullable();
            $table->foreignId('estado_evidencia_pago_id')->default(1)->constrained('estado_evidencia_pagos')->onDelete('restrict');
            $table->string('estado_registro')->default('PENDIENTE');

            $table->string('codigo_cliente')->nullable();
            $table->string('nombres_cliente')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('proyecto_nombre')->nullable();
            $table->string('etapa')->nullable();
            $table->string('lote')->nullable();
            $table->string('numero_cuota')->nullable();

            $table->string('gestor')->nullable();
            $table->foreignId('gestor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('fecha_registro')->nullable();

            //SUPERVISOR
            $table->foreignId('usuario_valida_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('validador')->nullable();
            $table->date('fecha_validacion')->nullable();

            //AUDITORIA
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencia_pago_antiguos');
    }
};
