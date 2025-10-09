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
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('min')->nullable();
            // $table->mediumBlob('image')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('necessities')->nullable();
        });
        DB::statement('ALTER TABLE activities ADD COLUMN image MEDIUMBLOB NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            //
        });
    }
};
