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

            $table->string('imagen_url')->nullable();
            $table->date('fecha_deposito')->nullable();
            $table->string('union')->nullable();
            $table->string('codigo_cliente')->nullable();
            $table->string('proyecto')->nullable();
            $table->string('etapa')->nullable();
            $table->string('lote')->nullable();
            $table->string('cliente')->nullable();
            $table->decimal('cuota_fija', 10, 2)->nullable();
            $table->decimal('monto', 10, 2)->nullable();
            $table->string('operacion_numero')->nullable();
            $table->string('operacion_hora')->nullable();
            $table->string('pago_de')->nullable();
            $table->string('codigo_cuenta')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->string('numero_cuota')->nullable();
            $table->string('moneda')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('medio_pago')->nullable();

            $table->string('estado_registro')->default('PENDIENTE');

            $table->string('gestor')->nullable();
            $table->foreignId('gestor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('fecha_registro')->nullable();
            $table->text('observacion')->nullable();

            $table->foreignId('validador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('validador')->nullable();
            $table->date('fecha_validacion')->nullable();

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
