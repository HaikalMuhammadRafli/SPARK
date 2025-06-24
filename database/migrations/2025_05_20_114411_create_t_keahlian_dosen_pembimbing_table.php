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
        Schema::create('t_keahlian_dosen_pembimbing', function (Blueprint $table) {
            $table->string('nip');
            $table->unsignedBigInteger('bidang_keahlian_id');
            $table->timestamps();

            $table->primary(['nip', 'bidang_keahlian_id']);

            $table->foreign('nip')->references('nip')->on('m_dosen_pembimbing');
            $table->foreign('bidang_keahlian_id')->references('bidang_keahlian_id')->on('m_bidang_keahlian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_keahlian_dosen_pembimbing');
    }
};
