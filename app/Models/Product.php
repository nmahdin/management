<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_id' , 'name' , 'color' , 'category_id' , 'picture' , 'owner' , 'price_materials' , 'salary' , 'profit' , 'total_price' , 'inventory', 'label' , 'notes' , 'deleted'];


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
}
