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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cliente_id')->constrained('users');
            $table->foreignId('area_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tipo_solicitud_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('sub_tipo_solicitud_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('canal_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('estado_ticket_id')->default(1)->constrained('estado_tickets')->cascadeOnDelete();
            $table->foreignId('prioridad_ticket_id')->default(3)->constrained('prioridad_tickets')->cascadeOnDelete();

            $table->foreignId('usuario_asignado_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('asunto_inicial');
            $table->text('descripcion_inicial');
            $table->json('lotes')->nullable();

            $table->string('asunto')->nullable();
            $table->text('descripcion')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
