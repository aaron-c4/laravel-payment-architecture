<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'provider',
        'amount',
        'status',
        'external_id',
        'user_id',
    ];

    // 2. Relación inversa: Pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
