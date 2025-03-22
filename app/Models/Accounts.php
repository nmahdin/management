<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accounts extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['number' , 'label' , 'inputs' , 'outputs' , 'payment_label' , 'count' , 'deleted' , 'note'];
}
