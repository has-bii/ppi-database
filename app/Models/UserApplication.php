<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'application_id',
        'app_status_id',
        'education_id',
        'nilai_ujian',
        'jurusan_1',
        'jurusan_2',
        'jurusan_3',
        'receipt',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function app_status()
    {
        return $this->belongsTo(AppStatus::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }
}
