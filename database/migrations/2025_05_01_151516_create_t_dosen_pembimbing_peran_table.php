<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDosenPembimbingPeranTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_dosen_pembimbing_peran', function (Blueprint $table) {
            $table->id('peran_id');
            $table->string('nip');
            $table->unsignedBigInteger('kelompok_id');
            $table->string('peran_nama');
            $table->timestamps();

            $table->foreign('nip')->references('nip')->on('m_dosen_pembimbing');
            $table->foreign('kelompok_id')->references('kelompok_id')->on('m_kelompok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_dosen_pembimbing_peran');
    }
}
;
