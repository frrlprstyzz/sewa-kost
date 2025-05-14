<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            if (!Schema::hasColumn('fasilitas', 'icon')) {
                $table->string('icon')->nullable()->after('nama_fasilitas');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->dropColumn('icon');
        });
    }
};
