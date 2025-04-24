<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->string('title'); 
            $table->string('subtitle'); 
            $table->string('platform')->nullable(); // Plataforma
            $table->string('campaign')->nullable(); // Campanha
            $table->string('resolution')->nullable(); // Resolução
            $table->double('weight')->nullable(); // Peso (em KB)
            $table->string('time')->nullable(); // Alterado para string para aceitar formatos de tempo como '0:00'
            $table->string('format')->nullable(); // Formato
            $table->string('company')->nullable(); // Empresa
            $table->string('type')->nullable(); // Tipo
            $table->string('file_path')->nullable(); // Caminho do arquivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtasks');
    }
};

