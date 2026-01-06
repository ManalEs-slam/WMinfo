<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('phone')->nullable()->after('email');
            $table->string('avatar_path')->nullable()->after('phone');
            $table->enum('role', ['admin', 'editor', 'reader'])->default('reader')->after('avatar_path');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('role');
            $table->json('permissions')->nullable()->after('status');
            $table->string('language', 10)->default('fr')->after('permissions');
            $table->string('timezone')->default('Europe/Paris')->after('language');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone',
                'avatar_path',
                'role',
                'status',
                'permissions',
                'language',
                'timezone',
            ]);
        });
    }
};
