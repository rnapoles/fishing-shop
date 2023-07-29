<?php

namespace App\Models;

use App\Traits\HasOptimisticLocking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasOptimisticLocking, HasFactory;

    // N .. N
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_role', 'role', 'user');
    }

    public $timestamps = false;

    protected $table = 'roles';
}
