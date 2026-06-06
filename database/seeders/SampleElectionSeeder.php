<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Election;
use App\Models\Candidate;

class SampleElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $election = Election::updateOrCreate(
            ['title' => 'Eme Eme Election 2026'],
            [
                'description' => 'Prototype election for testing the voting system.',
                'start_date' => now()->subDay(),
                'end_date' => now()->addDays(7),
            ]
        );

        // Presidents (3)
        $presidents = [
            'Mariella Ovido',
            'Mariphil Marigmen',
            'Manuelito Latiza',
        ];

        foreach ($presidents as $name) {
            Candidate::updateOrCreate(
                ['election_id' => $election->id, 'name' => $name, 'position' => Candidate::POSITION_PRESIDENT],
                ['name' => $name, 'election_id' => $election->id, 'position' => Candidate::POSITION_PRESIDENT]
            );
        }

        // Vice Presidents (3)
        $vices = [
            'Linda Park',
            'Diego Ramirez',
            'Chen Li',
        ];

        foreach ($vices as $name) {
            Candidate::updateOrCreate(
                ['election_id' => $election->id, 'name' => $name, 'position' => Candidate::POSITION_VICE],
                ['name' => $name, 'election_id' => $election->id, 'position' => Candidate::POSITION_VICE]
            );
        }

        // Senators (12)
        $senators = [
            'Maya Thompson',
            'Owen Brooks',
            'Fatima Hassan',
            'Noah Bennett',
            'Isabella Cruz',
            'Ethan Walker',
            'Sofia Martin',
            'Liam Scott',
            'Ava Nguyen',
            'Lucas Patel',
            'Amelia Rivera',
            'Jacob Kim',
        ];

        foreach ($senators as $name) {
            Candidate::updateOrCreate(
                ['election_id' => $election->id, 'name' => $name, 'position' => Candidate::POSITION_SENATOR],
                ['name' => $name, 'election_id' => $election->id, 'position' => Candidate::POSITION_SENATOR]
            );
        }
    }
}
