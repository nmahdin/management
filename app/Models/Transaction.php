<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name' , 'type' , 'date' , 'amount' , 'account_id' , 'category' , 'user_id' , 'label_id' , 'status' , 'payment_way' , 'source_type' , 'payer_id' , 'payer_type' , 'tracking_number' , 'source_id' , 'attached' , 'notes'];

    public function account()
    {
        return $this->belongsTo(Accounts::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function label()
    {
        return $this->belongsTo(TransactionLabel::class, 'label_id');
    }
}
