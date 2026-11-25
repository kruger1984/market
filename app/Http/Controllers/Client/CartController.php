<?php

declare(strict_types=1);

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Cart\StoreRequest;
use App\Http\Requests\Client\Cart\UpdateRequest;
use App\Http\Resources\Cart\CartWithProductResource;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class CartController extends Controller
{
    public function index(): Response
    {
        $carts = CartWithProductResource::collection(auth()->user()->carts)->resolve();

        return inertia('client/cart/Index', compact('carts'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        CartService::store($request->validated());

        return back()->with('success', 'Added to cart');
    }

    public function update(Cart $cart, UpdateRequest $request): RedirectResponse
    {
        CartService::update($cart, $request->validated());

        return back();
    }

    public function destroy(Cart $cart): RedirectResponse
    {
        $cart->delete();

        return redirect()
            ->back()
            ->with('success', 'Item deleted successfully!');
    }
}
