<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasiens extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'patients';

    public function transactions()
    {
        return $this->hasMany(Transactions::class, 'patient_id', 'id');
    }
}
