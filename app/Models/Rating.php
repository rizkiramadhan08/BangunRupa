<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id', 'desain_id', 'rating', 'komentar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function desain()
    {
        return $this->belongsTo(Desains::class, 'desain_id');
    }
}