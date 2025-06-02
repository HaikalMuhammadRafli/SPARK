<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMLombaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_lomba', function (Blueprint $table) {
            $table->id('lomba_id');
            $table->string('lomba_nama');
            $table->string('lomba_kategori');
            $table->string('lomba_penyelenggara');
            $table->string('lomba_lokasi_preferensi');
            $table->string('lomba_tingkat');
            $table->text('lomba_persyaratan');
            $table->date('lomba_mulai_pendaftaran');
            $table->date('lomba_akhir_pendaftaran');
            $table->string('lomba_link_registrasi');
            $table->date('lomba_mulai_pelaksanaan');
            $table->date('lomba_selesai_pelaksanaan');
            $table->integer('lomba_ukuran_kelompok')->default(1);
            $table->enum('lomba_status', ['buka', 'tutup', 'ditolak'])->default('tutup');
            $table->unsignedBigInteger('periode_id');
            $table->timestamp('validated_at')->nullable();
            $table->timestamps();

            $table->foreign('periode_id')->references('periode_id')->on('m_periode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_lomba');
    }
}
