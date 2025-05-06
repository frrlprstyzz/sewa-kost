<?php

// app/Models/Pengaduan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'kosan_id', 'isi_pengaduan', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kosan()
    {
        return $this->belongsTo(Kosan::class);
    }
}
