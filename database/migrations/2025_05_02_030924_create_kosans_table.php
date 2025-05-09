<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKosansTable extends Migration
{
    public function up()
    {
        Schema::create('kosans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('nama_kosan');
            $table->text('alamat');
            $table->text('deskripsi')->nullable();
            $table->integer('jumlah_kamar');
            $table->decimal('harga_per_bulan', 10, 2);
            $table->json('galeri')->nullable(); // ✅ disimpan sebagai JSON untuk multiple file
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kosans');
    }
}
