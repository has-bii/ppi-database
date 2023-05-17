<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'universitas_turki_id',
    ];

    public function universitasTurki()
    {
        return $this->belongsTo(UniversitasTurki::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }
}
