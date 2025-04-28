<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    // Menonaktifkan timestamps default
    public $timestamps = false;

    // Rename kolom timestamp default
    const CREATED_AT = 'CreatedDate';
    const UPDATED_AT = 'LastUpdatedDate';

    protected $guarded = [];
}
