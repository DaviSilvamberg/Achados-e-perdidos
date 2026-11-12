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
        Schema::table('objetos', function (Blueprint $table): void {
            $table->string('titulo', 120);
            $table->string('categoria', 100);
            $table->string('local', 150);
            $table->string('turno', 30);
            $table->text('descricao');
            $table->string('foto')->nullable();
            $table->string('status', 20)->default('disponível');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('objetos', function (Blueprint $table): void {
            $table->dropColumn([
                'titulo',
                'categoria',
                'local',
                'turno',
                'descricao',
                'foto',
                'status',
            ]);
        });
    }
};
