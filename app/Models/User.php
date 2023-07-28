<?php

namespace App\Models;

use App\Traits\HasOptimisticLocking;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasOptimisticLocking, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['roles'];

    public function getAuthToken(): ?string
    {

        $token = $this->createToken('MaryShop')->accessToken;

        return $token;
    }

    public function isAdmin(): bool
    {
        $roles = $this->getRoles();

        return in_array('ROLE_ADMIN', $roles);
    }

    public function getRoles(): array
    {
        return $this->roles->map(fn ($it) => $it->name)->toArray();
    }

    // N .. N
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user', 'role');
    }

    // 1 .. N
    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class, 'client_id', 'id');
    }
}
