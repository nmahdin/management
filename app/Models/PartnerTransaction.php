<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartnerTransaction extends Model
{
    use HasFactory , softDeletes;
    protected $fillable = ['partner_id','order_id','amount' , 'product_id' , 'type' , 'description' , 'date'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
