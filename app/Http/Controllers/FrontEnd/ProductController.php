<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::select('id', 'product_name', 'description', 'product_img', 'price', 'discount')->get();
        return view('frontEnd.product.index', compact('data'));
    }
}
