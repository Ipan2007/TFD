<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'transaction_id',
        'nama',
        'hp',
        'alamat',
        'metode',
        'total',
        'status',
        'bukti_pembayaran',
        'kurir',
        'ongkir',
        'no_resi',
        'expired_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}