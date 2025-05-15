<?php


namespace Database\Seeders;

use App\Models\Fasilitas;
use Illuminate\Database\Seeder;

class FasilitasSeeder extends Seeder
{
    public function run(): void
    {
        $facilities = [
            ['nama_fasilitas' => 'WiFi', 'icon' => 'fa-wifi'],
            ['nama_fasilitas' => 'AC', 'icon' => 'fa-snowflake'],
            ['nama_fasilitas' => 'Kamar Mandi Dalam', 'icon' => 'fa-bath'],
            ['nama_fasilitas' => 'Parkir Motor', 'icon' => 'fa-motorcycle'],
            ['nama_fasilitas' => 'Parkir Mobil', 'icon' => 'fa-car'],
            ['nama_fasilitas' => 'Dapur', 'icon' => 'fa-utensils'],
            ['nama_fasilitas' => 'Lemari', 'icon' => 'fa-archive'],
            ['nama_fasilitas' => 'Meja', 'icon' => 'fa-table'],
            ['nama_fasilitas' => 'Kasur', 'icon' => 'fa-bed'],
            ['nama_fasilitas' => 'TV', 'icon' => 'fa-tv'],
            ['nama_fasilitas' => 'Dispenser', 'icon' => 'fa-tint'],
            ['nama_fasilitas' => 'CCTV', 'icon' => 'fa-video']
        ];

        foreach ($facilities as $facility) {
            Fasilitas::create($facility);
        }
    }
}