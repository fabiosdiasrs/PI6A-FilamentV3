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
        Schema::create('dados_adicionais', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('qtde_filhos')->nullable;
            $table->boolean('irmao_instituicao')->nullable;
            $table->string('escola');
            $table->foreignId('pessoa_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('parentesco_resp')->nullable;
            $table->foreignId('aluno_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->decimal('renda_familiar')->nullable;
            $table->boolean('bolsa_familia')->default(0);
            $table->boolean('direito_imagem')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dados_adicionais');
    }
};
