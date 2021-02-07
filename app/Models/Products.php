<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    public function product_group()
    {
        return $this->belongsTo(ProductGroups::class, 'group_id', 'id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttrs::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }
}
