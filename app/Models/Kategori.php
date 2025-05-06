<?php

// app/Models/Kategori.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function kosans()
    {
        return $this->hasMany(Kosan::class);
    }
}
