<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeLayouts extends Model
{
    use HasFactory;

    protected $table = 'home_layouts';

    public function menus()
    {
        return $this->hasMany(Menus::class, 'id', 'menu_id');
    }
}
