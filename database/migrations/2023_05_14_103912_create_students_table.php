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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('name');
            $table->string('email');
            $table->bigInteger('status_id')->unsigned()->default(4);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('no_aktif')->nullable();
            $table->string('no_paspor')->nullable();
            $table->string('tc_kimlik')->nullable();
            $table->date('kimlik_exp')->nullable();
            $table->date('paspor_exp')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('provinsi_indonesia')->nullable();
            $table->string('kota_asal_indonesia')->nullable();
            $table->string('alamat_lengkap_indonesia')->nullable();
            $table->enum('jalur', ['Agen', 'Mandiri'])->nullable();
            $table->bigInteger('kota_turki_id')->unsigned()->nullable();
            $table->string('alamat_turki')->nullable();
            $table->string('tahun_kedatangan')->nullable();
            $table->string('photo')->nullable();
            $table->string('ikamet_file')->nullable();
            $table->string('ogrenci_belgesi')->nullable();
            $table->bigInteger('universitas_turki_id')->unsigned()->nullable();
            $table->bigInteger('jurusan_id')->unsigned()->nullable();
            $table->enum('jenjang_pendidikan', ['Lise', 'D3/D4', 'S1', 'S2', 'S3',])->nullable();
            $table->enum('tahun_ke', ['TÖMER', '1', '2', '3', '4', '5', '6'])->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
