<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    public const POSITION_PRESIDENT = 'President';
    public const POSITION_VICE = 'Vice President';
    public const POSITION_SENATOR = 'Senator';

    public static function positions(): array
    {
        return [
            self::POSITION_PRESIDENT,
            self::POSITION_VICE,
            self::POSITION_SENATOR,
        ];
    }

    protected $fillable = [
        'name',
        'election_id',
        'position',
    ];

    // Relationships
    public function election()
    {
        return $this->belongsTo(Election::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}

