<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Settlement extends Model
{
    use HasFactory , softDeletes;
    protected $fillable = [
        'partner_id', 'user_id', 'order_id', 'type' , 'amount', 'method', 'reference', 'description', 'settled_at'
    ];

    public function partner() {
        return $this->belongsTo(Partner::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
