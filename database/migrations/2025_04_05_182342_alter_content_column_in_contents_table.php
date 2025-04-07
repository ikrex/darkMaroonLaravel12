<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->longText('content')->change();
            $table->longText('content_english')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->text('content')->change();
            $table->text('content_english')->nullable()->change();
        });
    }
};
