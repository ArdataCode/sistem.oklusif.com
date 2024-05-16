<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'tindakan';

    public function transaction_tindak()
    {
        return $this->hasMany(TransactionTindakan::class, 'tindakan_id', 'id');
    }
}
