<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class products extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(10, 30) as $n) {
            DB::table('products')->insert([
                'name' => "محصول $n",
                'product_id' => "24040$n",
                'color' => 'قرمز',
                'category_id' => 1,
                'partner_id' => 1,
                'price_materials' => 450000,
                'total_price' => 600000,
                'inventory' => 4,
                'status_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
