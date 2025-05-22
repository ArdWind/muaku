<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $table = 'galleries';

    protected $fillable = [
        'name',
        'category',
        'image_path',
        'Status',
        'CreatedDate',
        'CreatedBy',
        'LastUpdatedDate',
        'LastUpdatedBy',
        'CompanyCode',
        'IsDeleted',
    ];

    public $timestamps = false; // karena kamu pakai CreatedDate, bukan timestamps default
}
