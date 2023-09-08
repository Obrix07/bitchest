<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cryptovalues extends Model
{
    use HasFactory;

    protected $fillable = [
        'cryptocurrency_id',
        'value',
        'value_date',
    ];

    public function cryptocurrency()
    {
        return $this->belongsTo(Cryptocurrency::class);
    }

    public $timestamps = false;
}
