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
        return Buyer::all();
    }

    /**
     * Returns the buyer details and a list of their transactions.
     * @param $id the identifier of the buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return Buyer::with('transactions')->find($id) ?: $this->showError('No se encontró comprador', [], 404);
    }
}
