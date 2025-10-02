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
            Schema::table('enrolled', function (Blueprint $table) {
                $table->string('status', 16)->default('attending')->after('activity_id');
                $table->unique(['activity_id', 'user_id'], 'enrolled_activity_user_unique');
            });
        }

        public function down(): void
        {
            Schema::table('enrolled', function (Blueprint $table) {
                $table->dropUnique('enrolled_activity_user_unique');
                $table->dropColumn('status');
            });
        }
};
