<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'role_id',
        'active',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function link()
    {
        return $this->hasMany(Link::class);
    }
}
