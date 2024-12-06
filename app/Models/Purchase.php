<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable = ['code' , 'picture' , 'name' , 'color' , 'amount' , 'unit' , 'unit_price' , 'total_price' , 'date' , 'category_id' , 'seller_id' , 'notes' , 'deleted'];
}
