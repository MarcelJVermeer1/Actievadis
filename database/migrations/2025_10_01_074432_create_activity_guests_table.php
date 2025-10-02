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
        Schema::create('activity_guests', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('activity_id');
                $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
                $table->string('name');
                $table->string('email');
                $table->string('phone')->nullable();
                $table->string('status', 16)->default('attending');
                $table->timestamp('email_verified_at')->nullable();
                $table->string('verification_token')->nullable();
                $table->timestamps();

                $table->unique(['activity_id', 'email']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_guests');
    }
};
