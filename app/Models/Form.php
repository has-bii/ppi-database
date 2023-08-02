<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'desc',
        'status_id',
        'role_id',
        'created_at',
        'updated_at',
    ];

    public function status()
    {
        return $this->belongsTo(FormStatus::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function question()
    {
        return $this->hasMany(Question::class);
    }
}
