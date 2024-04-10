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
        if (!Schema::hasTable('article_tags')) {
            Schema::create('article_tags', function (Blueprint $table) {
                $table->id();
                $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();;
                $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();;
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_tags');
    }
};
