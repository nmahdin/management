<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name' , 'note' , 'deleted'];

    public function products()
    {
        return $this->hasMany(Product::class , 'partner_id');
    }
}
