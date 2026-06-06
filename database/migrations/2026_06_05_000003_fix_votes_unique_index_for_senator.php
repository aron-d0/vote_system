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
            DB::statement('DROP INDEX IF EXISTS votes_user_id_election_id_position_unique');
            DB::statement('DROP INDEX IF EXISTS votes_user_id_election_id_unique');

            Schema::table('votes', function (Blueprint $table) {
                $table->unique(['user_id', 'candidate_id'], 'votes_user_id_candidate_id_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('votes')) {
            // Use raw statements to avoid exceptions on sqlite in-memory tests
            DB::statement('DROP INDEX IF EXISTS votes_user_id_candidate_id_unique');
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS votes_user_id_election_id_position_unique ON votes (user_id, election_id, position)');
        }
    }
};
