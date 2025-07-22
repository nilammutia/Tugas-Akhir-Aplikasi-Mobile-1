<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamen';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}
