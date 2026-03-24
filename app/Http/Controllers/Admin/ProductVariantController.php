<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProductVariantController extends Controller
{
    public function index(Product $product): View
    {
        return view('admin.products.variant', compact('product'));
    }

    public function storeVariant(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'sku'               => ['nullable', 'string'],
            'barcode'           => ['nullable', 'string'],
            'regular_price'     => ['required', 'numeric', 'min:0'],
            'selling_price'     => ['required', 'numeric', 'min:0'],
        ]);

        ProductVariant::updateOrCreate(
            ['product_id' => $product->id],
            [
                'sku' => $request->sku,
                'barcode' => $request->barcode,
                'regular_price' => $request->regular_price,
                'selling_price' => $request->selling_price,
            ]
        );

        return back()
            ->with('success', 'Product Variant saved successfully!!!');
    }
}
