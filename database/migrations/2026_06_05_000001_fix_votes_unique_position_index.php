<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            // If the old unique constraint still exists, replace it with the correct position-aware index.
            // Drop the old candidate-based unique index if it exists (sqlite safe)
            try {
                DB::statement('DROP INDEX IF EXISTS votes_user_id_election_id_candidate_id_unique');
            } catch (\Throwable $e) {
                // ignore
            }
            try {
                DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS votes_user_id_election_id_position_unique ON votes (user_id, election_id, position)');
            } catch (\Throwable $e) {
                // ignore if cannot create
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            try {
                DB::statement('DROP INDEX IF EXISTS votes_user_id_election_id_position_unique');
            } catch (\Throwable $e) {
                // ignore
            }
            try {
                DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS votes_user_id_election_id_candidate_id_unique ON votes (user_id, election_id, candidate_id)');
            } catch (\Throwable $e) {
                // ignore
            }
        });
    }
};
