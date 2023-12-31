<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cryptocurrency_id',
        'cryptovalues_id',
        'type',
        'quantity'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function cryptocurrency() {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public function cryptoValue() {
        return $this->belongsTo(CryptoValues::class, 'cryptovalues_id');
    }
}
