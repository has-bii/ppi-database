<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('nama_bapak');
            $table->string('nama_ibu');
            $table->enum('kelamin', ['laki-laki', 'perempuan']);
            $table->string('ttl');
            $table->string('no_paspor');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('alamat');
            $table->string('email');
            $table->string('no_hp');
            $table->string('no_hp_lain')->nullable();
            $table->string('nama_sekolah');
            $table->string('kota_sekolah');
            $table->string('pas_photo');
            $table->string('ijazah');
            $table->string('transkrip');
            $table->string('paspor');
            $table->string('surat_rekomendasi');
            $table->string('surat_izin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_infos');
    }
};
