<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'status_id',
        'jenis_kelamin',
        'agama',
        'tc_kimlik',
        'kimlik_exp',
        'tanggal_lahir',
        'provinsi_indonesia',
        'kota_asal_indonesia',
        'alamat_lengkap_indonesia',
        'jalur',
        'kota_turki_id',
        'alamat_turki',
        'whatsapp',
        'no_aktif',
        'tahun_kedatangan',
        'photo',
        'no_paspor',
        'paspor_exp',
        'ikamet_file',
        'ogrenci_belgesi',
        'universitas_turki_id',
        'jurusan_id',
        'jenjang_pendidikan',
        'tahun_ke',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function kotaTurki()
    {
        return $this->belongsTo(KotaTurki::class, 'kota_turki_id');
    }

    public function universitasTurki()
    {
        return $this->belongsTo(UniversitasTurki::class, 'universitas_turki_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
