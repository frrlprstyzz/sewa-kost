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
            ['nama_fasilitas' => 'Dapur', 'icon' => 'fa-kitchen-set'],
            ['nama_fasilitas' => 'Lemari', 'icon' => 'fa-drawer'],
            ['nama_fasilitas' => 'Meja', 'icon' => 'fa-table'],
            ['nama_fasilitas' => 'Kasur', 'icon' => 'fa-bed']
        ];

        foreach ($facilities as $facility) {
            Fasilitas::create($facility);
        }
    }
}