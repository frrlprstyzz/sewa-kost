<?php

// database/migrations/xxxx_xx_xx_create_pembayarans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kosan_id')->constrained()->onDelete('cascade');

            $table->string('bukti_pembayaran')->nullable();
            $table->date('tanggal_bayar');
            $table->integer('durasi_sewa');
            $table->decimal('total_harga', 10, 2);
            $table->enum('status', ['pending', 'diterima', 'ditolak', 'dibatalkan'])->default('pending');
            $table->string('kode_pembayaran', 10)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembayarans');
    }
};
