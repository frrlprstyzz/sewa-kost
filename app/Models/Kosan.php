<?php

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
        'galeri' => 'array', // ✅ otomatis konversi JSON ke array di Laravel
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    // Relasi ke fasilitas
    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class);
    }

    // Relasi ke pengaduan
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    // Relasi ke pembayaran
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
