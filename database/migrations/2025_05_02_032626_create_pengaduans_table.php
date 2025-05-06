<?php

// database/migrations/xxxx_xx_xx_create_pengaduans_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kosan_id')->constrained()->onDelete('cascade');

            $table->text('isi_pengaduan');
            $table->enum('status', ['menunggu', 'diproses', 'selesai'])->default('menunggu');

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengaduans');
    }
};
