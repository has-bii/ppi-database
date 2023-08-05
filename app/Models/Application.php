<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'active',
        'app_status_id',
    ];

    public function app_status()
    {
        return $this->belongsTo(AppStatus::class);
    }

    public function user_application()
    {
        return $this->hasMany(UserApplication::class);
    }
}
