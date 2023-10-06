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
        Schema::create('pessoas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->date('dt_nascimento');
            $table->string('estado_civil');
            $table->string('cpf')->unique();
            $table->string('rg')->unique();
            $table->string('nis')->unique();
            $table->string('email');
            $table->string('telefone');
            $table->char('sexo');
            $table->string('rua');
            $table->string('cep');
            $table->string('complemento')->nullable();
            $table->string('Bairro');
            $table->integer('numero');
            $table->foreignId('pais_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('estado_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('cidade_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
