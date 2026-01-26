<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('articles')
            ->where('featured_image', 'like', 'C:%')
            ->update(['featured_image' => null]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is a data correction and is not reversible.
    }
};