<?php

namespace App\Usecases\Product;

use App\DTO\Product\ProductItem;
use App\Models\Product;

class ListProductsUsecase {

  //todo add pagination
  public function execute(): array {

   $inStock = Product::query('available_in_stock', true)->get();
   $selection = [];

   foreach($inStock as $product){
     $item = new ProductItem();
     $item->id = $product->id;
     $item->serial = $product->serial_number;
     $item->name = $product->name;
     $item->price = $product->sale_price;
     $item->unitsInStock = $product->units_in_stock;
     $item->category = $product->category->name;

     $selection[] = $item;
   }

    return $selection;
  }

}
