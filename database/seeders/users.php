<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 3) as $n) {
            DB::table('users')->insert([
                'name' => "کاربر $n",
                'username' => "user$n",
                'email' => "user$n@gmail.com",
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now(),

            ]);
        }

    }
}
