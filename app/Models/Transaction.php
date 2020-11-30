<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity',
        'user_id',
        'product_id'
    ];

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($transaction) {
            $product = Product::find($transaction->product_id);
            $product->quantity -= $transaction->quantity;
            $product->update();
        });
    }

    /**
     * Product sold
     */
    public function product()
    {
        return $this->hasOne(Product::class);
    }

    /**
     * User who buys
     */
    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }
}
