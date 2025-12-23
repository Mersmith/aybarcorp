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
        Schema::create('direccions', function (Blueprint $table) {
            $table->id();

            
            $table->unsignedBigInteger('user_id');
            $table->string('recibe_nombres');
            $table->string('recibe_celular');

            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('provincia_id');
            $table->unsignedBigInteger('distrito_id');

            $table->string('direccion');
            $table->string('direccion_numero');
            $table->string('opcional')->nullable();
            $table->string('codigo_postal');
            $table->string('instrucciones')->nullable();
            $table->boolean('es_principal')->default(false);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('provincia_id')->references('id')->on('provincias')->onDelete('cascade');
            $table->foreign('distrito_id')->references('id')->on('distritos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direccions');
    }
};
