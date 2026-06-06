<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->whereDate('start_at', '<=', now())
                     ->whereDate('end_at', '>=', now());
    }

    public function isActive(): bool
    {
        return $this->start_at && $this->end_at && $this->start_at->lte(now()) && $this->end_at->gte(now());
    }

    public function getStartAtAttribute($value)
    {
        if ($value) {
            return $this->asDateTime($value);
        }

        return isset($this->attributes['start_date']) ? $this->asDateTime($this->attributes['start_date']) : null;
    }

    public function getEndAtAttribute($value)
    {
        if ($value) {
            return $this->asDateTime($value);
        }

        return isset($this->attributes['end_date']) ? $this->asDateTime($this->attributes['end_date']) : null;
    }

    // Relationships
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
