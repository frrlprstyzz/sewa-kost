<?php

// app/Models/Pembayaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kosan_id',
        'bukti_pembayaran',
        'tanggal_bayar',
        'durasi_sewa',
        'total_harga',
        'status'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date',
        'total_harga' => 'decimal:2',
        'durasi_sewa' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kosan()
    {
        return $this->belongsTo(Kosan::class);
    }

    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }
}
