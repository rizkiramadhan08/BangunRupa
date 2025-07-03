<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Desains extends Model
{
    // Nama tabel jika tidak mengikuti konvensi (jamak = koleksis)
    protected $table = 'desains';

    // Kolom yang bisa diisi
    protected $fillable = [
        'gambar',
        'nama_produk',
        'nama_desainer',
        'harga',
        'ukuran_lahan',
        'lantai',
        'luas_tanah',
        'kamar_tidur',
        'luas_bangunan',
        'kamar_mandi',
        'gaya_desain',
        'deskripsi',
    ];

    public function ratings()
    {
    return $this->hasMany(Rating::class, 'desain_id');
    }

}
