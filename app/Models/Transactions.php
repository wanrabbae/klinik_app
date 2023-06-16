<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'transactions';

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasiens::class, 'patient_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction_tindak()
    {
        return $this->hasMany(TransactionTindakan::class, 'transaction_id', 'id');
    }
}
