<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModels extends Model
{
    use HasFactory;
    protected $table = 'product_models';
    protected $fillable = [
        'product_name',
        'product_description',
        'product_quantity',
        'product_price',
        'category',
        'status',
    ];
}
