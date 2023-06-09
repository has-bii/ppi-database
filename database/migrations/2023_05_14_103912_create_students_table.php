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
            $table->string('name')->nullable();
            $table->string('email');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('agama')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('provinsi_indonesia')->nullable();
            $table->string('kota_asal_indonesia')->nullable();
            $table->string('alamat_lengkap_indonesia')->nullable();

            $table->enum('tempat_tinggal', ['Apartemen', 'Asrama'])->nullable();
            $table->bigInteger('kota_turki_id')->unsigned()->nullable();
            $table->string('alamat_turki')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('no_aktif')->nullable();

            $table->date('tahun_masuk')->nullable();

            $table->string('photo')->nullable();
            $table->string('no_ikamet')->nullable();
            $table->string('ikamet_file')->nullable();
            $table->string('ogrenci_belgesi')->nullable();

            $table->bigInteger('universitas_turki_id')->unsigned()->nullable();
            $table->bigInteger('jurusan_id')->unsigned()->nullable();
            $table->enum('jenjang_pendidikan', ['Lise', 'S1', 'S2', 'S3',])->nullable();
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
