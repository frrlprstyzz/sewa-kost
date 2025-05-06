<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kosans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained()->onDelete('cascade');

            $table->string('nama_kosan');
            $table->text('alamat');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_kamar');
            $table->decimal('harga_per_bulan', 10, 2);

            $table->json('galeri')->nullable(); // Menyimpan array URL gambar

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kosans');
    }
};