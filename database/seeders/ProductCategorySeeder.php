<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['name' => 'Fashion'],
            ['name' => 'Books'],
            ['name' => 'Movies'],
            ['name' => 'Music'],
            ['name' => 'Electronics'],
            ['name' => 'Collectibles & Art'],
            ['name' => 'Home & Garden'],
            ['name' => 'Sporting Goods'],
            ['name' => 'Toys & Hobbies'],
            ['name' => 'Business & Industrial'],
        ];

        foreach($categories as $category){
            ProductCategory::create($category);
        }
    }
}
