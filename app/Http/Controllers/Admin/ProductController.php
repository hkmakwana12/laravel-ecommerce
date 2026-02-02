<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreRequest as ProductStoreRequest;
use App\Http\Requests\Admin\Product\UpdateRequest as ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\DomCrawler\Crawler;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = QueryBuilder::for(Product::class)
            ->allowedFilters([
                // Global search across multiple fields
                AllowedFilter::callback('search', function ($query, $value) {
                    $query->search($value);
                }),
            ])
            ->with(['brand', 'category', 'media'])
            ->allowedSorts(['name', 'category_id', 'brand_id'])
            ->defaultSort('-created_at')
            ->paginate()
            ->appends(request()->query());


        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $product = new Product();

        $brands = Brand::all()->pluck('name', 'id');
        $categories = Category::all()->pluck('name', 'id');

        return view('admin.products.form', compact('product', 'brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {

        $product = Product::create($request->validated());

        if ($request->hasFile('featured-image')) {
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

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::all()->pluck('name', 'id');
        $categories = Category::all()->pluck('name', 'id');

        return view('admin.products.form', compact('product', 'brands', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {

        $product->fill($request->validated());
        $product->save();

        if ($request->hasFile('featured-image')) {
            $product->clearMediaCollection('featured-image');
            $product->addMediaFromRequest('featured-image')
                ->preservingOriginal()
                ->toMediaCollection('featured-image');
        }

        if ($request->hasFile('product-images')) {
            $product->clearMediaCollection('product-images');
            foreach ($request->file('product-images') as $image) {
                $product->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('product-images');
            }
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->clearMediaCollection('featured-image');

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }


    /**
     * Search Product by name
     */
    public function search(Request $request)
    {
        $products = Product::where('name', 'like', '%' . $request->q . '%')
            ->select(['id', 'name', 'selling_price'])
            ->latest()
            ->take(10)
            ->get();

        return response()->json($products);
    }

    public function import()
    {
        return view('admin.products.import');
    }

    public function importStore(Request $request)
    {
        $barcode = $request->input('barcode');
        $sku = $request->input('sku');
        $price = $request->input('price');

        $url = "https://go-upc.com/search?q={$barcode}";

        // Fetch the HTML content
        $response = Http::get($url);


        $html = $response->body();

        // Use DomCrawler to parse HTML
        $crawler = new Crawler($html);

        // Extract product name (example selector, adjust based on actual HTML)
        $productName = $crawler->filter('h1')->first()->text();

        // Extract EAN, UPC, Brand, Category, Description, etc.
        // For example, extract table rows with EAN, UPC, Brand:
        $details = [];
        // get table with class is table and tbody
        $crawler->filter('table tr')->each(function (Crawler $row) use (&$details) {
            $tds = $row->filter('td');
            // Check if there are at least 2 <td> elements
            if ($tds->count() >= 2) {
                $key = trim($tds->eq(0)->text());
                $value = trim($tds->eq(1)->text());
                $details[$key] = $value;
            }
        });

        // Extract Description (example selector)
        $description = $crawler->filter('h2:contains("Description") + span')->count() ?
            $crawler->filter('h2:contains("Description") + span')->text() : null;

        $ingredients = $crawler->filter('h2:contains("Ingredients") + span')->count() ?
            $crawler->filter('h2:contains("Ingredients") + span')->text() : null;

        $additionalAttributesArr = $crawler->filter('h2:contains("Additional Attributes") + ul li')->each(function ($node) {
            return $node->text();
        });

        // get image figure class is product-image and element is img
        $image = $crawler->filter('figure.product-image img')->first()->attr('src');

        // $additionalAttributes is in , seperated with each and after that separated with :
        // so we need to split it into array
        // $additionalAttributesArr = explode(',', $additionalAttributes);
        // now convert into ul and li
        $additionalAttributesStr = '<ul>';
        foreach ($additionalAttributesArr as $key => $value) {
            $value = explode(':', $value);
            if (count($value) == 2) {
                $additionalAttributesStr .= '<li><strong>' . trim($value[0]) . '</strong> : ' . trim($value[1]) . '</li>';
            }
        }
        $additionalAttributesStr .= '</ul>';

        // dd($productName, $details, $description, $ingredients, $additionalAttributesArr, $additionalAttributesStr, $image);

        $ingredients = $ingredients ? '<h2>Ingredients</h2><p>' . $ingredients . '</p>' : '';
        $additionalAttributesStr = $additionalAttributesStr ? '<h2>Product Specification</h2>' . $additionalAttributesStr : '';

        // Save to database

        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            $product = new Product();
        }

        /**
         * For Brand
         */
        $brandName = $details['Brand'] ?? null;

        $brand = new Brand();

        if ($brandName) {
            $brand = Brand::where('name', $brandName)->first();
            if (!$brand) {

                // if slug exists then add slug -1
                $brandSlug = str($brandName)->slug();

                $brandSlugCount = Brand::where('slug', $brandSlug)->count();
                if ($brandSlugCount > 0) {
                    $brandSlug = $brandSlug . '-' . ($brandSlugCount + 1);
                }

                $brand = new Brand();
                $brand->name = $brandName;
                $brand->slug = $brandSlug;
                $brand->save();
            }
        }
        /**
         * For Category
         */

        $categoryName = $details['Category'] ?? null;

        $category = new Category();

        if ($categoryName) {
            $category = Category::where('name', $categoryName)->first();
            if (!$category) {

                // if slug exists then add slug -1
                $categorySlug = str($categoryName)->slug();

                $categorySlugCount = Category::where('slug', $categorySlug)->count();
                if ($categorySlugCount > 0) {
                    $categorySlug = $categorySlug . '-' . ($categorySlugCount + 1);
                }

                $category = new Category();
                $category->name = $categoryName;
                $category->slug = $categorySlug;
                $category->save();
            }
        }

        $slug = str($productName . '-' . $barcode)->slug();

        $product->brand_id = $brand?->id;
        $product->category_id = $category?->id;
        $product->name = $productName;
        $product->slug = $slug;
        $product->barcode = $barcode;
        $product->sku = $sku;
        $product->regular_price = $price;
        $product->selling_price = $price;
        $product->short_description = $description;
        $product->long_description = $ingredients . $additionalAttributesStr;
        $product->seo_title = $productName;
        $product->save();

        // remove images from product
        $product->clearMediaCollection('product-images');
        $product->clearMediaCollection('featured-image');

        $product->addMediaFromUrl($image)
            ->preservingOriginal()
            ->toMediaCollection('featured-image');

        return redirect()
            ->route('admin.products.import')
            ->with('success', 'Product imported successfully.');
    }
}
