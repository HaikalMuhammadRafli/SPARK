<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_mahasiswa', function (Blueprint $table) {
            $table->string('nim', 10)->primary();
            $table->string('nama');
            $table->enum('lokasi_preferensi',['Kota','Provinsi', 'Nasional', 'Internasional']);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('program_studi_id');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('m_user');
            $table->foreign('program_studi_id')->references('program_studi_id')->on('m_program_studi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_mahasiswa');
    }
}
