<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class permissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
           [ 'name' => 'edit-users', 'label' => 'ویرایش کاربران', 'note' => 'می تواند نام، نام کاربری و... کاربران را ویرایش کند.' ],
           [ 'label' => 'مشاهده کاربران' , 'name' => 'show-users', 'note' => 'می تواند لیست کاربران را ببیند' ],
           [ 'label' => 'مشاهده مشتری ها' , 'name' => 'show-customers', 'note' => null ],
           [ 'label' => 'ویرایش مشتری ها' ,'name' => 'edit-customers', 'note' => null ],
           [ 'label' => 'ویرایش فاکتور ها' ,'name' => 'edit-orders', 'note' => null ],
           [ 'label' => 'مشاهده فاکتور ها' ,'name' => 'show-orders', 'note' => null ],
        ];
        Permission::insert($data);
    }
}
