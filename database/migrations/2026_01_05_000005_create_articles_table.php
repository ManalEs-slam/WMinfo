<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 500)->nullable();
            $table->longText('content');
            $table->string('region')->nullable();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->enum('visibility', ['public', 'private', 'unlisted'])->default('public');
            $table->json('tags')->nullable();
            $table->string('featured_image')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->index(['status', 'published_at']);
            $table->index(['category_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
