<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Fauzantaqiyuddin\LaravelMinio\Facades\Miniojan;

class GalleryController extends Controller
{
    public function weddingDetail()
    {
        $galleries = Gallery::where('category', 'WEDDING')->get();
    
        // Tidak perlu generate URL jika image_path sudah URL penuh
        return view('detail.weding', compact('galleries'));
    }

    /**
     * Tampilkan daftar galeri
     */
    public function index()
    {
        $galleries = Gallery::all();
        return view('data_galeries.indexGaleries', compact('galleries'));
    }

    /**
     * Tampilkan form tambah galeri
     */
    public function create()
    {
        return view('data_galeries.create');
    }

    /**
     * Simpan galeri baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|in:WEDDING,BRIDESMAID,ENGAGEMENT DAY,GRADUATION',
            'image'    => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        $data['image_path'] = $this->uploadToMinio($request);
        $data['CreatedBy'] = Auth::user()->name;
        $data['CreatedDate'] = now();

        Gallery::create($data);

        return redirect()->route('data_galeries.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit galeri
     */
    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('data_galeries.edit', compact('gallery'));
    }

    /**
     * Update galeri
     */
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|in:WEDDING,BRIDESMAID,ENGAGEMENT DAY,GRADUATION',
            'image'    => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama dari MinIO jika ada
            if ($gallery->image_path) {
                $oldFile = basename(parse_url($gallery->image_path, PHP_URL_PATH));
                Miniojan::delete('galery', $oldFile);
            }

            $data['image_path'] = $this->uploadToMinio($request);
        }

        $data['LastUpdatedBy'] = Auth::user()->name;
        $data['LastUpdatedDate'] = now();

        $gallery->update($data);

        return redirect()->route('data_galeries.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    /**
     * Hapus galeri
     */
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        if ($gallery->image_path) {
            $fileName = basename(parse_url($gallery->image_path, PHP_URL_PATH));
            Miniojan::delete('galery', $fileName);
        }

        $gallery->delete();

        return redirect()->route('data_galeries.index')->with('success', 'Galeri berhasil dihapus.');
    }

    /**
     * Upload gambar ke MinIO
     */
    private function uploadToMinio(Request $request)
    {
        $file = $request->file('image');
        $directory = 'galery';

        $localPath = $file->store('temp', 'local');
        $fullPath = Storage::disk('local')->path($localPath);

        $uploadedUrl = Miniojan::upload($directory, $fullPath);

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        return $uploadedUrl;
    }
}
