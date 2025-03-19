<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CustomerCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['id', 'category_name' , 'notes'];

    public function customers()
    {
        return $this->hasMany(Customer::class, 'category_id');
    }

}
