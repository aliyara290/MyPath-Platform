<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("title");
            $table->string("description")->nullable();
            $table->string("url");
            $table->foreignUuid("course_id")->constrained("courses")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
