<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTMahasiswaPeranTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_mahasiswa_peran', function (Blueprint $table) {
            $table->id('peran_id');
            $table->string('nim');
            $table->unsignedBigInteger('kelompok_id');
            $table->string('peran_nama');
            $table->timestamps();

            $table->foreign('nim')->references('nim')->on('m_mahasiswa');
            $table->foreign('kelompok_id')->references('kelompok_id')->on('m_kelompok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_mahasiswa_peran');
    }
}
;
