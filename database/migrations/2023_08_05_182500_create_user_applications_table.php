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
        Schema::create('user_applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('application_id')->unsigned();
            $table->integer('app_status_id')->default(4);
            $table->integer('education_id');
            $table->float('nilai_ujian');
            $table->string('jurusan_1');
            $table->string('jurusan_2');
            $table->string('jurusan_3');
            $table->string('receipt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_applications');
    }
};
