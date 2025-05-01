<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_code',
        'product_name',
        'description',
        'product_img',
        'price',
        'discount',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'LastUpdatedDate',
        'LastUpdatedBy',
    ];

    public $timestamps = false;
}
