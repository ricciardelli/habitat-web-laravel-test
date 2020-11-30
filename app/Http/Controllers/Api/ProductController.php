<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\BuyProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Returns a list of products in stock. If <code>show_products_without_stock</code> query string parameter is
     * present, then the list with no stock are also returned.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if (is_null($request->input('show_products_without_stock'))) {
            return Product::where('quantity', '>', 0)->get();
        } else {
            return Product::all();
        }
    }

    /**
     * Creates a transaction for the current user who decides to buy the specified product. Transaction is created only
     * if the required quantity is available in stock.
     *
     * @param BuyProductRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(BuyProductRequest $request, $id)
    {
        $product = Product::find($id);

        if ($product) {
            $quantity = $request->validated()['quantity'];

            if ($quantity > $product->quantity) {
                return $this->showError('No se dispone de la cantidad de productos solicitada. Intente con una cantidad menor.', [], 400);
            }

            $transaction = $product->transactions()->create(['quantity' => $quantity, 'user_id' => $request->user()->id, 'product_id' => $product->id]);

            if ($transaction) {
                return $transaction;
            } else {
                return $this->showError('No se pudo procesar la transacción', [], 404);
            }

        } else {
            return $this->showError('No se encontró el producto', [], 404);
        }
    }

    /**
     * Returns the product by the specified id.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return Product::find($id) ?: $this->showError('No se encontró el producto', [], 404);
    }
}
