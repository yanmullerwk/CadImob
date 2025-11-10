<?php

use Faker\Guesser\Name;
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
        Schema::create('averbacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('imovel_id')->constrained('imoveis','id')->onDelete('cascade');
            $table->string('EventType');    
            $table->decimal('measure', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamp('data')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('averbacoes');
    }
};
