<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_id' , 'name' , 'color' , 'category_id' , 'picture' , 'partner_id' , 'price_materials' , 'salary' , 'profit' , 'total_price' , 'inventory', 'label' , 'note' , 'status_id' , 'deleted'];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function category(): MorphOne
    {
        return $this->morphOne(Category::class , 'categoryable');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function status()
    {
        return $this->morphOne(Status::class ,'statusable');
    }
}
