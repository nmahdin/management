<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name' , 'deleted' , 'number' , 'city' , 'address' , 'history' , 'com_ways' , 'notes' , 'birthday'];

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
