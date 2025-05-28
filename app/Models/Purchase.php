<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['code' , 'picture' , 'name' , 'color' , 'amount' , 'unit' , 'unit_price' , 'total_price' , 'date' , 'category_id' , 'seller_id' , 'notes' ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'source_id')
            ->where('source_type', 'purchases');
    }
}
