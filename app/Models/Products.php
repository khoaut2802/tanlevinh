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
}
