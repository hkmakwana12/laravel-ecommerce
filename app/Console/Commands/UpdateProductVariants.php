<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateProductVariants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:variants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update or create product variants using updateOrCreate';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Product::chunk(100, function ($products) {
            foreach ($products as $product) {
                DB::transaction(function () use ($product) {
                    ProductVariant::updateOrCreate(
                        ['product_id' => $product->id],
                        [
                            'sku' => $product->sku,
                            'barcode' => $product->barcode,
                            'regular_price' => $product->regular_price,
                            'selling_price' => $product->selling_price,
                        ]
                    );
                });
            }
        });

        $this->info("✅ Bulk update completed!");
    }
}
