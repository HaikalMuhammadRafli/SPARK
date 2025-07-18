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
        Schema::create('t_keahlian_lomba', function (Blueprint $table) {
            $table->unsignedBigInteger('lomba_id');
            $table->unsignedBigInteger('bidang_keahlian_id');
            $table->timestamps();

            $table->primary(['lomba_id', 'bidang_keahlian_id']);

            $table->foreign('lomba_id')->references('lomba_id')->on('m_lomba');
            $table->foreign('bidang_keahlian_id')->references('bidang_keahlian_id')->on('m_bidang_keahlian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_keahlian_lomba');
    }
};
