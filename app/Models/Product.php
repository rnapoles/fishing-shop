<?php

namespace App\Models;

use App\Traits\HasOptimisticLocking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Uuid\Uuid;

class Product extends Model
{
    use HasOptimisticLocking, HasFactory;

    public function __construct(array $attributes = [])
    {
        $this->serial_number = (string) Uuid::uuid4();
        $this->available_in_stock = true;
        parent::__construct($attributes);
    }

    // N .. 1
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // N .. N
    public function sales(): BelongsToMany
    {
        return $this->belongsToMany(Sale::class, 'product_sale', 'product', 'sale');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'purchase_price', 'sale_price', 'units_in_stock', 'category_id',
    ];

    public $timestamps = false;

    protected $table = 'products';
}
