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

            $table->foreignId('unidad_negocio_id')->nullable()->constrained('unidad_negocios')->nullOnDelete(); //ok
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete(); //ok
            $table->foreignId('cliente_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('imagen_url')->nullable(); //ok

            $table->string('operacion_numero')->nullable(); //ok
            $table->string('operacion_hora')->nullable(); //ok
            $table->string('union')->nullable(); //ok
            $table->decimal('cuota_fija', 10, 2)->nullable(); //ok
            $table->decimal('monto', 10, 2)->nullable(); //ok
            $table->string('pago_de')->nullable(); //ok
            $table->string('codigo_cuenta')->nullable(); //ok
            $table->string('nombre_archivo')->nullable(); //ok
            $table->string('moneda')->nullable(); //ok
            $table->string('medio_pago')->nullable(); //ok
            $table->date('fecha_deposito')->nullable(); //ok

            $table->text('observacion')->nullable();
            $table->foreignId('estado_evidencia_pago_id')->default(1)->constrained('estado_evidencia_pagos')->onDelete('restrict'); //ok
            $table->string('estado_registro')->default('PENDIENTE'); //ok

            $table->string('dni_cliente')->nullable(); //ok
            $table->string('codigo_cliente')->nullable(); //ok
            $table->string('nombres_cliente')->nullable(); //ok
            $table->string('razon_social')->nullable(); //ok
            $table->string('proyecto_nombre')->nullable(); //ok
            $table->string('etapa')->nullable(); //ok
            $table->string('lote')->nullable(); //ok
            $table->string('numero_cuota')->nullable(); //ok

            $table->foreignId('gestor_id')->nullable()->constrained('users')->nullOnDelete(); //ok
            $table->string('gestor')->nullable(); //ok
            $table->date('fecha_registro')->nullable(); //ok

            //SUPERVISOR
            $table->foreignId('usuario_valida_id')->nullable()->constrained('users')->nullOnDelete(); //asignado
            $table->string('validador')->nullable(); //ok
            $table->date('fecha_validacion')->nullable(); //ok

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
