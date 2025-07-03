<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    // Izinkan kolom ini untuk mass assignment
    protected $fillable = [
        'user_id',
        'desain_id',
        'status',
        'purchased_at'
    ];

    // Jika tidak ingin pakai created_at dan updated_at, bisa set ini ke false
    public $timestamps = true;

    // Relasi ke desain
    public function desain()
    {
        return $this->belongsTo(Desains::class, 'desain_id');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}