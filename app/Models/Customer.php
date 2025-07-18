<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id', 'name'  , 'number' , 'city' , 'address' , 'history' , 'com_ways' , 'notes' , 'birthday' , 'gender' , 'category_id' , 'attachment'];

    public function category() {
        return $this->belongsTo(CustomerCategory::class , 'category_id');
    }
    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function transactions()
    {
        return $this->morphMany(\App\Models\Transaction::class, 'payer');
    }
}
