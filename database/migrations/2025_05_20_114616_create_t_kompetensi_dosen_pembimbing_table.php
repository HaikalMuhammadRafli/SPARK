<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_kompetensi_dosen_pembimbing', function (Blueprint $table) {
            $table->string('nip');
            $table->unsignedBigInteger('kompetensi_id');
            $table->timestamps();

            $table->primary(['nip', 'kompetensi_id']);

            $table->foreign('nip')->references('nip')->on('m_dosen_pembimbing');
            $table->foreign('kompetensi_id')->references('kompetensi_id')->on('m_kompetensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_kompetensi_dosen_pembimbing');
    }
};
