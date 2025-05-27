<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
 use App\Models\Kategori;
 
class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
 

public function run()
{
    Kategori::create(['nama_kategori' => 'Kos Putra']);
    Kategori::create(['nama_kategori' => 'Kos Putri']);
    Kategori::create(['nama_kategori' => 'Kos Campuran']);
}

}
