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
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Terreno', 'Casa', 'Apartamento']);
            $table->decimal('areaTerreno', 8, 2)->nullable();
            $table->decimal('areaEdificacao', 8, 2)->nullable();
            $table->string('logradouro');
            $table->string('numero');
            $table->string('bairro');
            $table->string('complemento')->nullable();
            $table->foreignId('contribuinte_id')->constrained('pessoas')->onDelete('cascade');
            $table->enum('situacao', ['ATIVO', 'INATIVO'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis');
    }
};
