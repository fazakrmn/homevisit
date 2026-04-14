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
            $table->date('tanggal_konsultasi')->nullable();
            $table->time('waktu_konsultasi')->nullable();
            $table->text('permasalahan')->nullable();
            $table->string('dokter')->nullable();
            $table->enum('status_pendaftaran', ['pending', 'approved', 'rejected'])->default('pending');  
            $table->string('pembayaran')->nullable();
            $table->enum('status_step', ['step1', 'step2', 'step3', 'selesai'])->default('step1');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftarans');
    }
};
