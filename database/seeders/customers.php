<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class customers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(10, 30) as $n) {
            DB::table('customers')->insert([
                'name' => "مشتری $n",
                'number' => "091254386$n",
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        }
    }
}
