<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductImageController extends Controller
{
    public function index(Product $product): View
    {
        return view('admin.products.image', compact('product'));
    }

    public function storeImage(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'featured-image'    => ['nullable', 'image', 'max:1024'],
            'product-images'    => ['nullable', 'array'],
            'product-images.*'  => ['image', 'max:1024'],
        ]);

        if ($request->hasFile('featured-image')) {
            $product->clearMediaCollection('featured-image');
            $product->addMediaFromRequest('featured-image')
                ->preservingOriginal()
                ->toMediaCollection('featured-image');
        }

        if ($request->hasFile('product-images')) {
            foreach ($request->file('product-images') as $image) {
                $product->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('product-images');
            }
        }

        return back()
            ->with('success', 'Image Uploaded successfully!!!');
    }

    public function deleteImage(Request $request, Product $product): RedirectResponse
    {

        $mediaId = $request->input('media_id');
        $product->deleteMedia($mediaId);

        return back()
            ->with('success', 'Image Deleted successfully!!!');
    }
}
