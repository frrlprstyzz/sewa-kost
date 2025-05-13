<?php

// app/Models/Fasilitas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    
    protected $fillable = [
        'nama_fasilitas',
        'icon'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // Relasi many-to-many ke Kosan
    public function kosans()
    {
        return $this->belongsToMany(Kosan::class, 'kosan_fasilitas');
    }
}

