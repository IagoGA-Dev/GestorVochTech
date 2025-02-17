<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // First drop existing foreign keys
        Schema::table('unidades', function (Blueprint $table) {
            $table->dropForeign(['bandeira_id']);
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropForeign(['unidade_id']);
        });

        // Re-add with correct onDelete cascade
        Schema::table('unidades', function (Blueprint $table) {
            $table->foreign('bandeira_id')
                  ->references('id')
                  ->on('bandeiras')
                  ->onDelete('cascade');
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->foreign('unidade_id')
                  ->references('id')
                  ->on('unidades')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        // Drop and recreate with original constraints
        Schema::table('unidades', function (Blueprint $table) {
            $table->dropForeign(['bandeira_id']);
            $table->foreign('bandeira_id')
                  ->references('id')
                  ->on('bandeiras');
        });

        Schema::table('colaboradores', function (Blueprint $table) {
            $table->dropForeign(['unidade_id']);
            $table->foreign('unidade_id')
                  ->references('id')
                  ->on('unidades');
        });
    }
};
