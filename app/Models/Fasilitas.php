<?php

// app/Models/Fasilitas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $fillable = ['kosan_id', 'nama_fasilitas'];

    public function kosan()
    {
        return $this->belongsTo(Kosan::class);
    }
}

