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
        Schema::table('candidates', function (Blueprint $table) {
            $table->string('position')->default('Senator')->after('election_id');
        });

        Schema::table('votes', function (Blueprint $table) {
            $table->string('position')->nullable()->after('election_id');
            $table->unique(['user_id', 'election_id', 'candidate_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'election_id', 'candidate_id']);
            $table->dropColumn('position');
        });

        Schema::table('candidates', function (Blueprint $table) {
            $table->dropColumn('position');
        });
    }
};
