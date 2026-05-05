<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        $cart = cart();

        $bestSellingProducts = Product::latest('view_count')->active()->with('media')->take(4)->get();

        return view('front.cart', compact('cart', 'bestSellingProducts'));
    }

    public function addToCart(Request $request)
    {
        $cart = cart();

        $cartItem = $cart?->items()
            ->where('variant_id', $request->variant_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $cartItem = $cart?->items()
                ->create(
                    [
                        'product_id' => $request->product_id,
                        'variant_id' => $request->variant_id,
                        'quantity' => $request->quantity,
                    ]
                );
        }

        $itemTotal = $cartItem->product->selling_price * $cartItem->quantity;

        applyTaxesToObject($cartItem, $itemTotal);

        return redirect()->back()
            ->with('success', 'Product added to cart successfully!!!');
    }

    public function removeFromCart(int $variant_id): RedirectResponse
    {
        $cartItem = cart()->items()->where('variant_id', $variant_id)
            ->first();

        $cartItem->taxes()->delete();

        $cartItem->delete();

        return redirect()->back()
            ->with('success', 'Product removed from Wishlist!!!');
    }

    public function updateCart(Request $request): RedirectResponse
    {
        $cart = cart();

        foreach ($request->quantity as $variant_id => $quantity) {
            $cartItem = $cart?->items()
                ->where('variant_id', $variant_id)
                ->first();

            $cartItem->quantity = $quantity;
            $cartItem->save();

            $itemTotal = $cartItem->variant->selling_price * $cartItem->quantity;

            applyTaxesToObject($cartItem, $itemTotal);
        }

        return redirect()->route('account.checkout')
            ->with('success', 'Cart updated successfully!!!');
    }

    public function listCart(Request $request)
    {
        $cart = cart();

        return response()->json([
            'cart' => $this->formatCart($cart),
        ]);
    }

    private function formatCart($cart)
    {
        $items = $cart->items()
            ->with(['product', 'variant'])
            ->get();

        return [
            'items' => $items->map(function ($item) {
                return [
                    'id' => $item->id,
                    'variant_id' => $item->variant_id,
                    'image' => $item->product->thumbnailURL('thumb'),
                    'name' => $item->product->name,
                    'price' => $item->variant->selling_price,
                    'quantity' => $item->quantity,
                    'total' => round($item->variant->selling_price * $item->quantity, 2),
                    'item_url' => route('products.show', $item->product->slug),
                ];
            }),
            'count' => $items->count(),
            'taxes' => $cart->tax_breakdown,
            'sub_total' => $cart->total,
            'total_tax_amount' => $cart->total_tax_amount,
            'grand_total' => round($cart->total + $cart->total_tax_amount, 2),
        ];
    }
}
