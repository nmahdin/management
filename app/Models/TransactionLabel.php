<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionLabel extends Model
{
    use HasFactory;
    use softDeletes;

    protected $table = 'transactions_labels';

    protected $fillable = ['name', 'notes'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'label_id');
    }
}
