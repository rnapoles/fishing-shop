<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver2
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        echo __CLASS__ . "::" . __FUNCTION__ . "\n";
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        echo __CLASS__ . "::" . __FUNCTION__ . "\n";
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        echo __CLASS__ . "::" . __FUNCTION__ . "\n";
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        echo __CLASS__ . "::" . __FUNCTION__ . "\n";
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        echo __CLASS__ . "::" . __FUNCTION__ . "\n";
    }
}
