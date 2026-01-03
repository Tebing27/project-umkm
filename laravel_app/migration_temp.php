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
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('text_hash')->index();
            $table->text('original_text');
            $table->text('translated_text');
            $table->string('source_lang')->default('id');
            $table->string('target_lang')->default('en');
            $table->timestamps();

            $table->unique(['text_hash', 'target_lang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
