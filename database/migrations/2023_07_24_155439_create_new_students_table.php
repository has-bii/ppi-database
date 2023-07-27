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
        Schema::create('new_students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->unique();
            $table->string('name');
            $table->string('email');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('provinsi_indonesia');
            $table->string('kota_asal_indonesia');
            $table->string('alamat_lengkap_indonesia');
            $table->string('whatsapp');
            $table->string('no_paspor');
            $table->enum('jenjang_pendidikan', ['S1', 'S2', 'S3',]);
            $table->bigInteger('jurusan_id')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_students');
    }
};
