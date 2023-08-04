<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = [
        'my_menu_id',
        'name',
        'url',
        'icon',
        'active',
    ];

    public function status()
    {
        return $this->belongsTo(MyMenu::class);
    }
}
