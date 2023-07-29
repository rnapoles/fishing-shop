<?php

namespace App\Usecases\Sale;

use App\Exceptions\ValidationException;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Throwable;
use Validator;

class CreateSaleUsecase
{
    public function execute(array $input, array $roles = ['ROLE_CLIENT']): Sale
    {

        $validator = Validator::make($input, [
            'client_id' => 'required|exists:users,id',
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        try {
            DB::beginTransaction();

            $sale = Sale::create([
              'client_id' => $input['client_id'],
            ]);

            //map keys and quantity
            $products = $input['products'];
            $productQuantity = [];
            $productKeys = [];
            foreach ($products as $product) {
              $id = $product['id'];
              $productKeys[] = $id;
              $productQuantity[$id] = $product['quantity'];
            }

            //find selected products in database and reduce stock
            $products = Product::whereIn('id', $productKeys)->get();
            foreach ($products as $product) {
                $id = $product->id;
                $quantity = $productQuantity[$id];
                $product->reduceStock($quantity);
                $sale->products()->attach($id, ['quantity' => $quantity]);
                $product->save();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }

        return $sale;
    }
}
