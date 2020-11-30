<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ProductRequest;
use App\Models\Product;
use App\Models\Seller;

class SellerController extends Controller
{
    /**
     * Returns a list of sellers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return $this->showAll(Seller::all());
    }

    /**
     * Creates a product for the current authenticated user.
     * @param ProductRequest $request
     * @return mixed
     */
    public function product(ProductRequest $request)
    {
        $product = $request->validated();
        $product['user_id'] = $request->user()->id;
        return $this->showOne(Product::create($product));
    }

    /**
     * Returns the seller details with their associated products.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $seller = Seller::with('products')->find($id);
        if ($seller) {
            return $this->showOne($seller);
        } else {
            return $this->showError('No se encontró vendedor', [], 404);
        }
    }
}
