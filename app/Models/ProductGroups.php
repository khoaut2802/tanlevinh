<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductGroups extends Model
{
    use HasFactory;

    protected $table = 'product_groups';

    public function products()
    {
        return $this->hasMany(Products::class, 'group_id', 'id');
    }
}
