<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('birth_details');
            $table->string('email');
            $table->string('phone');
            $table->string('payment_method');
            $table->string('love_language_test_file')->nullable();
            $table->text('question1')->nullable();
            $table->string('question2')->nullable();
            $table->integer('question3')->nullable();
            $table->text('question4')->nullable();
            $table->string('question5')->nullable();
            $table->text('desire')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
