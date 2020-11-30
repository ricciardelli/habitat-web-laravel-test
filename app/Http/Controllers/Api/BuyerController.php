<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buyer;

class BuyerController extends Controller
{
    /**
     * Returns all buyers (a buyer is a user who has transactions)
     */
    public function index()
    {
        return $this->showAll(Buyer::all());
    }

    /**
     * Returns the buyer details and a list of their transactions.
     * @param $id the identifier of the buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $buyer = Buyer::with('transactions')->find($id);
        if ($buyer) {
            return $this->showOne($buyer);
        } else {
            return $this->showError('No se encontró comprador', [], 404);
        }
    }
}
