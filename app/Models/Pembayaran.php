<?php

// app/Models/Pembayaran.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kosan_id', 'bukti_pembayaran', 'tanggal_bayar', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kosan()
    {
        return $this->belongsTo(Kosan::class);
    }
}
