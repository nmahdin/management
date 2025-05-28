<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id' , 'customer_id' , 'user_id' , 'date' , 'products' , 'amount' , 'extra_expenses' , 'status' , 'note' , 'tax' , 'services' , 'profit' , 'discount' , 'payments' , 'account_id' , 'type_id'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity', 'total_price', 'unit_price');
    }

    public function type()
    {
        return $this->belongsTo(type::class);
    }

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'source_id')
            ->where('source_type', 'orders');
    }
}
