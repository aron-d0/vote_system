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
        if (! Schema::hasColumn('votes', 'election_id')) {
            Schema::table('votes', function (Blueprint $table) {
                $table->unsignedBigInteger('election_id')->after('candidate_id');
                $table->index('election_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('votes', 'election_id')) {
            Schema::table('votes', function (Blueprint $table) {
                $table->dropIndex(['election_id']);
                $table->dropColumn('election_id');
            });
        }
    }
};
