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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('unidad_negocio_id')->constrained('unidad_negocios')->onDelete('cascade');
            $table->foreignId('grupo_proyecto_id')->constrained('grupo_proyectos')->onDelete('cascade');

            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->longText('contenido')->nullable();
            $table->json('secciones')->nullable();
            $table->string('imagen')->nullable();
            $table->dateTime('publicado_en')->nullable();
            $table->boolean('activo')->default(false);

            $table->json('documento')->nullable();

            // SEO opcional
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_image')->nullable();
            $table->unsignedBigInteger('views')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyectos');
    }
};
