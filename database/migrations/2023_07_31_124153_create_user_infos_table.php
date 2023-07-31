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
            $table->string('name');
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->date('tanggal_lahir');
            $table->string('email');
            $table->string('whatsapp');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('alamat');
            $table->string('pas_photo');
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
