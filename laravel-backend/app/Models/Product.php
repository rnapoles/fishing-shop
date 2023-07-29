<?php

namespace App\Models;

use App\Models\CategoryId;
use App\Traits\HasOptimisticLocking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Ramsey\Uuid\Uuid;

class Product extends Model
{
    use HasOptimisticLocking, Searchable, HasFactory;

    public function __construct(array $attributes = [])
    {
        //$this->category_id = CategoryId::HightRange->value;
        $this->serial_number = (string) Uuid::uuid4();
        parent::__construct($attributes);
    }

    public function assignCategory()
    {

        $salePrice = $this->sale_price;
        $purchasePrice = $this->purchase_price;

        if(!$purchasePrice){
          return;
        }

        // calc profit margin percent
        $gainPercent = (($salePrice - $purchasePrice) / $purchasePrice) * 100;

        if ($gainPercent < 10) {
            $this->category_id = CategoryId::LowRange->value;
        } elseif ($gainPercent >= 10 && $gainPercent <= 20) {
            $this->category_id = CategoryId::MidRange->value;
        } else {
            $this->category_id = CategoryId::HightRange->value;
        }

    }

    /**
     * Update calculate fields
     */
    public function updateCalculateFields(): void
    {
        $this->assignCategory();
        $this->available_in_stock = $this->units_in_stock > 0;
    }

    /**
     * Reduce stock quantity
     */
    public function reduceStock(int $quantity): void
    {

        $total = $this->units_in_stock;

        if($total >= $quantity){
          $this->units_in_stock -= $quantity;
        } else {
          throw new \Exception("The product \"{$this->name}\" is out of stock");
        }

        $this->available_in_stock = $this->units_in_stock > 0;
    }

    /**
     * Get the name of the index associated with the model.
     */
    public function searchableAs(): string
    {
        return 'product_index';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        return $array;
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
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['category'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name', 'purchase_price', 'sale_price', 'units_in_stock'
    ];

    public $timestamps = false;

    protected $table = 'products';
}
