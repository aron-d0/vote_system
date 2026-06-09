<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Vote;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

#[Fillable(['name', 'email', 'password', 'is_admin', 'voter_id', 'api_token'])]
#[Hidden(['password', 'remember_token', 'api_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function generateVoterId()
    {
        if (! $this->voter_id) {
            $this->voter_id = 'VOTER-' . strtoupper(uniqid()) . '-' . $this->id;
            $this->save();
        }
        return $this->voter_id;
    }

    public function getQrCodeUrl()
    {
        $voterId = $this->generateVoterId();
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($voterId);
    }

    public function createApiToken(): string
    {
        $this->api_token = Str::random(80);
        $this->save();

        return $this->api_token;
    }
}
