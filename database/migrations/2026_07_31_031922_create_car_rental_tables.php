<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Modifikasi tabel users (tambah alamat, no telp, no SIM)
        Schema::table('users', function (Blueprint $table) {
            $table->text('alamat')->nullable()->after('email');
            $table->string('nomor_telepon')->nullable()->after('alamat');
            $table->string('nomor_sim')->nullable()->unique()->after('nomor_telepon');
        });

        // 2. Tabel Cars (Mobil)
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('merek');
            $table->string('model');
            $table->string('nomor_plat')->unique();
            $table->decimal('tarif_per_hari', 12, 2);
            $table->timestamps();
        });

        // 3. Tabel Rentals (Peminjaman & Pengembalian)
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_cost', 12, 2)->nullable();
            $table->enum('status', ['rented', 'returned'])->default('rented');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
        Schema::dropIfExists('cars');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alamat', 'nomor_telepon', 'nomor_sim']);
        });
    }
};