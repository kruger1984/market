<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Cart;

class CartService
{
    /**
     * @param  array<string, mixed>  $data
     */
    public static function store(array $data): Cart
    {
        return auth()->user()->carts()->create($data);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public static function update(Cart $cart, array $data): Cart
    {
        $cart->update($data);

        return $cart->fresh();
    }
}
