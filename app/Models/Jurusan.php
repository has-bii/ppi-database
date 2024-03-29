<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function new_student()
    {
        return $this->hasMany(NewStudent::class);
    }
}
