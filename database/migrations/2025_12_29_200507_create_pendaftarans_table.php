<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('no_telepon', 12);
            $table->text('alamat');
            $table->string('nik', 16)->unique();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            
            // Data step 2 - Pilih Jadwal
            $table->date('tanggal_konsultasi')->nullable();
            $table->time('waktu_konsultasi')->nullable();
            
            // Data step 3 - Permasalahan
            $table->text('permasalahan')->nullable();
            $table->string('kategori_masalah')->nullable();
            
            // Data step 4 - Dokumen
            $table->string('dokumen_ktp')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            
            // Status tracking
            $table->enum('status_step', ['1', '2', '3', '4', 'selesai'])->default('1');
            $table->enum('status_pendaftaran', ['draft', 'pending', 'approved', 'rejected'])->default('draft');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftarans');
    }
};
