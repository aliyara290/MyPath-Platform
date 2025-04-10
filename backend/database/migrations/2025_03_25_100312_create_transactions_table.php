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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("user_id")->constrained("users")->onDelete("cascade");
            $table->string("strip_payment_intent")->unique();
            $table->decimal("amount, 10, 2");
            $table->string("currency", 3)->default("USD");
            $table->enum("status", ["pending", "succeeded", "failed"])->default("pending");
            $table->string("payment_method")->nullable();
            $table->json("metadata")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
