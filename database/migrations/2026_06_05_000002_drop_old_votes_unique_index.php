<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('votes')) {
            DB::statement('DROP INDEX IF EXISTS votes_user_id_election_id_unique');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('votes')) {
            Schema::table('votes', function (Blueprint $table) {
                $table->unique(['user_id', 'election_id']);
            });
        }
    }
};
