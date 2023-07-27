<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewStudent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'jenis_kelamin',
        'tanggal_lahir',
        'provinsi_indonesia',
        'kota_asal_indonesia',
        'alamat_lengkap_indonesia',
        'whatsapp',
        'no_paspor',
        'jenjang_pendidikan',
        'jurusan_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }
}
