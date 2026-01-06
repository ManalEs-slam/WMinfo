<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('article_stats', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('article_id')->constrained()->cascadeOnDelete();
            $table->date('stat_date');
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('comments_count')->default(0);
            $table->unsignedBigInteger('shares_count')->default(0);
            $table->timestamps();

            $table->unique(['article_id', 'stat_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_stats');
    }
};
