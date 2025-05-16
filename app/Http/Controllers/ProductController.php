<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Fauzantaqiyuddin\LaravelMinio\Facades\Miniojan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function DataProductView()
    {
        $products = Product::all();
        return view('data_products.indexProducts', compact('products'));
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
            'product_img'  => 'required|image|mimes:jpg,jpeg,png',
            'price'        => 'required|numeric',
            'discount'     => 'nullable|numeric',
            'Status'       => 'nullable|integer',
        ]);

        // // Pastikan folder ada
        // $path = public_path('asset/products_img');
        // if (!File::exists($path)) {
        //     File::makeDirectory($path, 0777, true);
        // }

        // // Proses upload gambar
        // if ($request->hasFile('product_img')) {
        //     $extension = $request->file('product_img')->getClientOriginalExtension();
        //     $imgName = $data['product_code'] . '.' . $extension;
        //     $request->file('product_img')->move($path, $imgName);
        //     $data['product_img'] = 'asset/products_img/' . $imgName;
        // }

        $data['product_img'] = $this->sendToMinio($request);
        $data['CreatedBy'] = Auth::user()->name; // Wajib login
        $data['CreatedDate'] = now();

        Product::create($data);

        return redirect()->route('data_products.index')->with('success', 'Produk berhasil ditambahkan.');
    }


    private function sendToMinio($request)
    {
        $file = $request->file('product_img');
        $directory = 'galery';

        // Simpan file ke disk lokal
        $path = $file->store('temp', 'local');
        $filePath = Storage::disk('local')->path($path);

        // Upload file ke MinIO
        $response = Miniojan::upload($directory, $filePath);

        // Hapus file lokal setelah upload
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return $response;
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
            'description'  => 'nullable|string',
            'product_img'  => 'nullable|image|mimes:jpg,jpeg,png',
            'price'        => 'required|numeric',
            'discount'     => 'nullable|numeric',
            'Status'       => 'nullable|integer',
        ]);

        // $path = public_path('asset/products_img');
        // if (!File::exists($path)) {
        //     File::makeDirectory($path, 0777, true);
        // }

        // // Jika ada file gambar baru yang diunggah
        // if ($request->hasFile('product_img')) {
        //     // Hapus file lama berdasarkan nama product_code (berapapun ekstensinya)
        //     $oldPattern = $path . '/' . $product->product_code . '.*';
        //     foreach (glob($oldPattern) as $oldFile) {
        //         if (file_exists($oldFile)) {
        //             unlink($oldFile); // hapus semua file yang cocok
        //         }
        //     }

        //     // Simpan file baru dengan nama sesuai product_code
        //     $extension = $request->file('product_img')->getClientOriginalExtension();
        //     $imgName = $data['product_code'] . '.' . $extension;
        //     $request->file('product_img')->move($path, $imgName);
        //     $data['product_img'] = 'asset/products_img/' . $imgName;
        // }

        // Jika ada file baru
        if ($request->hasFile('product_img')) {
            // Hapus gambar lama di MinIO jika ada
            if ($product->product_img) {
                $oldUrl = $product->product_img;
                $oldFileName = basename(parse_url($oldUrl, PHP_URL_PATH)); // Ambil nama file dari URL

                // Hapus dari MinIO
                Miniojan::delete('galery', $oldFileName);
            }

            // Upload gambar baru ke MinIO
            $file = $request->file('product_img');
            $tempPath = $file->store('temp', 'local');
            $fullPath = Storage::disk('local')->path($tempPath);

            $uploadedPath = Miniojan::upload('galery', $fullPath);

            // Hapus file lokal
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            $data['product_img'] = $uploadedPath;
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
        // if ($product->product_img && File::exists(public_path($product->product_img))) {
        //     File::delete(public_path($product->product_img));
        // }

        // Hapus gambar dari MinIO jika ada
        if ($product->product_img) {
            // Ambil nama file dari URL gambar
            $fileName = basename(parse_url($product->product_img, PHP_URL_PATH));
            Miniojan::delete('galery', $fileName);
        }
        // Hapus produk dari database
        $product->delete();

        return redirect()->route('data_products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
