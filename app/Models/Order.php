<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    // Penting: Set ini menjadi false agar Eloquent tidak mencari created_at dan updated_at
    public $timestamps = false;

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'CustomerName',
        'Address',
        'Phone',
        'BookingDate',
        'Product',
        'Quantity',
        'TotalPrice',
        'OrderStatus',
        'PaymentStatus',
        // 'CreatedDate' tidak perlu di fillable karena diisi oleh useCurrent() di database
        'CreatedBy',
        'LastUpdatedDate',
        'LastUpdatedBy',
        'CompanyCode',
        'IsDeleted',
        'InvoiceNumber',
    ];
}
