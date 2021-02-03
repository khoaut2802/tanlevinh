<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;

    protected $table = 'menus';

    public function page()
    {
        return $this->belongsTo(Pages::class, 'id', 'menu_id');
    }
}
