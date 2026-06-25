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
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('start_at', '<=', now())
            ->where('end_at', '>=', now());
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

    public function setStartAtAttribute($value): void
    {
        $this->attributes['start_at'] = $value;
        $this->attributes['start_date'] = $value ? $this->asDateTime($value)->toDateString() : null;
    }

    public function getEndAtAttribute($value)
    {
        if ($value) {
            return $this->asDateTime($value);
        }

        return isset($this->attributes['end_date']) ? $this->asDateTime($this->attributes['end_date']) : null;
    }

    public function setEndAtAttribute($value): void
    {
        $this->attributes['end_at'] = $value;
        $this->attributes['end_date'] = $value ? $this->asDateTime($value)->toDateString() : null;
    }

    public function setStartDateAttribute($value): void
    {
        $this->attributes['start_date'] = $value;

        if ($value && empty($this->attributes['start_at'])) {
            $this->attributes['start_at'] = $this->asDateTime($value);
        }
    }

    public function setEndDateAttribute($value): void
    {
        $this->attributes['end_date'] = $value;

        if ($value && empty($this->attributes['end_at'])) {
            $this->attributes['end_at'] = $this->asDateTime($value);
        }
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
