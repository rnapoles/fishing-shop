<?php

namespace App\Usecases\Product;

use App\DTO\User\AuthenticatedUser;
use App\Exceptions\ValidationException;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Throwable;
use Validator;

class CreateProductUsecase
{
    public function execute(array $input, array $roles = ['ROLE_CLIENT']): Product
    {

        $validator = Validator::make($input, [
            'name' => 'required|unique:products',
            'purchase_price' => 'required|decimal:0,2',
            'sale_price' => 'required|decimal:0,2',
            'units_in_stock' => 'required|integer|min:0',
            //'category_id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors);
        }

        //$dto = new AuthenticatedUser();

        try {
            DB::beginTransaction();

            $product = new Product($input);
            $product->updateCalculateFields();
            $product->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollback();

            throw $e;
        }

        return $product;
    }
}
