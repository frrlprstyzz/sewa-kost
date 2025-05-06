<?php

// app/Models/Kosan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kosan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'nama_kosan',
        'alamat',
        'deskripsi',
        'jumlah_kamar',
        'harga_per_bulan',
        'galeri',
    ];

    protected $casts = [
        'galeri' => 'array', // untuk field JSON
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class);
    }

    public function fasilitas() {
        return $this->hasMany(Fasilitas::class);
    }

    public function pengaduans() {
        return $this->hasMany(Pengaduan::class);
    }

    public function pembayarans() {
        return $this->hasMany(Pembayaran::class);
    }
}

