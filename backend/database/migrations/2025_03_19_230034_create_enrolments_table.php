<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('enrolments', function (Blueprint $table) {
            $table->uuid('course_id');
            $table->uuid('user_id');
            $table->enum('progress', ['in_progress', 'completed'])->default('in_progress');
            $table->primary(['course_id', 'user_id']);
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrolments');
    }
};
