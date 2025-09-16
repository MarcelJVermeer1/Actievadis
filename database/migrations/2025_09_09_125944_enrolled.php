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
        Schema::create('enrolled', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->uuid('activity_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['user_id', 'activity_id']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('enrolled');
    }
};
