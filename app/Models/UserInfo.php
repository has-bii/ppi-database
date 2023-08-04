<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_depan',
        'nama_belakang',
        'nama_bapak',
        'nama_ibu',
        'kelamin',
        'ttl',
        'no_paspor',
        'provinsi',
        'kota',
        'alamat',
        'email',
        'no_hp',
        'no_hp_lain',
        'nama_sekolah',
        'kota_sekolah',
        'pas_photo',
        'ijazah',
        'transkrip',
        'paspor',
        'surat_rekomendasi',
        'surat_izin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
