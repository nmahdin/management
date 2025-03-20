<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchasesCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'purchases_category';
    protected $fillable = ['name' , 'notes', 'deleted'];
}
