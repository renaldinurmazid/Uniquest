<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('label')->nullable()->after('name');
            $table->text('description')->nullable()->after('label');
            $table->string('color', 20)->default('#a78bfa')->after('description');
            $table->boolean('is_system')->default(false)->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn(['label', 'description', 'color', 'is_system']);
        });
    }
};
