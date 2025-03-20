<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductStatus extends Model
{

    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'note' ];
    protected $table = 'products_statuses';
}
