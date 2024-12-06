<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['id' , 'customer_id' , 'date' , 'products' , 'price' , 'extra_expenses' , 'status_id' , 'note' , 'tax' , 'services' , 'profit' , 'discount' , 'payments' , 'account_id' , 'type_id'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
