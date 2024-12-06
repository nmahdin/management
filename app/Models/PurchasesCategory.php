<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasesCategory extends Model
{
    use HasFactory;
    protected $table = 'purchases_category';
    protected $fillable = ['name' , 'notes', 'deleted'];
}
