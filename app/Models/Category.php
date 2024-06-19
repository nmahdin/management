<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'label' , 'notes' , 'deleted'];


    public function products() :hasMany
    {
        return $this->hasMany(Product::class);
    }
}
