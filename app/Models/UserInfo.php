<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'tanggal_lahir',
        'email',
        'whatsapp',
        'provinsi',
        'kota',
        'alamat',
        'pas_photo'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
