<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static count()
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name' , 'label' , 'notes' ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
