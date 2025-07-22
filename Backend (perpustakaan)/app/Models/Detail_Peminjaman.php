<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detail_Peminjaman extends Model
{
    protected $table = 'detail__peminjamen';
    protected $fillable = [
        'peminjaman_id',
        'buku_id',
        'jumlah',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}
