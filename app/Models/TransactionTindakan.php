<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTindakan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'transaction_tindakans';

    public function tindakan()
    {
        return $this->belongsTo(Tindakan::class, "tindakan_id");
    }
}
