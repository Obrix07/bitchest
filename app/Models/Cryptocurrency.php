<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol'
    ];

    public function values() {
        return $this->hasMany(CryptoValue::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function wallets() {
        return $this->hasMany(Wallet::class);
    }
}
