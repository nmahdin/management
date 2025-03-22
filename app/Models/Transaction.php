<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name' , 'type' , 'date' , 'amount' , 'account_id' , 'category_id' , 'user_id' , 'status' , 'source_type' , 'source_id' , 'reference' , 'attached' , 'notes'];
}
