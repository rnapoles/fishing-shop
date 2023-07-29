<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

class Sale extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        $this->serial_number = (string) Uuid::uuid4();
        $this->creation_date = new \DateTime();
        parent::__construct($attributes);
    }

    // N .. 1
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    // N .. N
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_sale', 'sale', 'product')->withPivot('quantity');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
    ];

    public $timestamps = false;

    protected $table = 'sales';
}
