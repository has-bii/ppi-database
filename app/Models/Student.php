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
        'jenis_kelamin',
        'agama',
        'tempat_lahir',
        'tanggal_lahir',
        'provinsi_indonesia',
        'kota_asal_indonesia',
        'alamat_lengkap_indonesia',
        'tempat_tinggal',
        'kota_turki_id',
        'alamat_turki',
        'whatsapp',
        'no_aktif',
        'tahun_kedatangan',
        'photo',
        'tc_kimlik',
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

    public function kotaTurki()
    {
        return $this->belongsTo(KotaTurki::class, 'kota_turki_id');
    }

    public function universitasTurki()
    {
        return $this->belongsTo(UniversitasTurki::class, 'universitas_turki_id');
    }

    public function ppi()
    {
        return $this->belongsTo(Ppi::class, 'ppi_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
