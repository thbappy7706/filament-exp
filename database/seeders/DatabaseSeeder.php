<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,

        ]);

        // Seed Categories (with parent-child example)
        Category::factory(25)->create()->each(function ($parent) {
            Category::factory(20)->create([
                'parent_id' => $parent->id,
            ]);
        });

        // Seed Brands
        $brands = Brand::factory(30)->create();

        // Seed Products
        $brands->each(function ($brand) {
            Product::factory(25)->create([
                'brand_id' => $brand->id,
            ]);
        });

        // Seed Customers
        Customer::factory(20)->create()->each(function ($customer) {
            // Each customer has 1-5 orders
            Order::factory(rand(1, 5))->create([
                'customer_id' => $customer->id,
            ])->each(function ($order) {
                // Each order has 1-5 order items
                OrderItem::factory(rand(1, 5))->create([
                    'order_id' => $order->id,
                    'product_id' => Product::query()->inRandomOrder()->first()->id,
                ]);
            });
        });





    }
}
