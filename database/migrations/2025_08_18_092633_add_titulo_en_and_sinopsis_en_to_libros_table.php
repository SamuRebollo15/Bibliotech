<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->string('titulo_en')->nullable()->after('titulo');
            $table->text('sinopsis_en')->nullable()->after('sinopsis');
        });
    }

    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->dropColumn(['titulo_en', 'sinopsis_en']);
        });
    }
};
