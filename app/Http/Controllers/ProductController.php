<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function DataProductView()
    {
        $products = Product::all(); // Menampilkan semua produk tanpa filter
        $users = User::all();
        return view('data', compact('users', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('data_products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_code' => 'required|unique:products',
            'product_name' => 'required',
            'description'  => 'nullable|string',
            'product_img'  => 'nullable|image|mimes:jpg,jpeg,png',
            'price'        => 'required|numeric',
            'discount'     => 'nullable|numeric',
            'Status'       => 'nullable|integer',
        ]);

        // Pastikan folder ada
        $path = public_path('asset/products_img');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        // Proses upload gambar
        if ($request->hasFile('product_img')) {
            $extension = $request->file('product_img')->getClientOriginalExtension();
            $imgName = $data['product_code'] . '.' . $extension;
            $request->file('product_img')->move($path, $imgName);
            $data['product_img'] = 'asset/products_img/' . $imgName;
        }

        $data['CreatedBy'] = Auth::user()->name; // Wajib login
        $data['CreatedDate'] = now();

        Product::create($data);

        return redirect()->route('data_products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('data_products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id,
            'product_name' => 'required',
            'product_img' => 'nullable|image|mimes:jpg,jpeg,png',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'Status' => 'nullable|integer',
        ]);

        $path = public_path('asset/products_img');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0777, true);
        }

        // Jika ada file gambar baru yang diunggah
        if ($request->hasFile('product_img')) {
            // Hapus file lama berdasarkan nama product_code (berapapun ekstensinya)
            $oldPattern = $path . '/' . $product->product_code . '.*';
            foreach (glob($oldPattern) as $oldFile) {
                if (file_exists($oldFile)) {
                    unlink($oldFile); // hapus semua file yang cocok
                }
            }

            // Simpan file baru dengan nama sesuai product_code
            $extension = $request->file('product_img')->getClientOriginalExtension();
            $imgName = $data['product_code'] . '.' . $extension;
            $request->file('product_img')->move($path, $imgName);
            $data['product_img'] = 'asset/products_img/' . $imgName;
        }

        $data['LastUpdatedBy'] = Auth::user()->name;
        $data['LastUpdatedDate'] = now();

        $product->update($data);

        return redirect()->route('data_products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar produk jika ada
        if ($product->product_img && File::exists(public_path($product->product_img))) {
            File::delete(public_path($product->product_img));
        }

        // Hapus produk dari database
        $product->delete();

        return redirect()->route('data_products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
