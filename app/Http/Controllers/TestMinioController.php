<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Fauzantaqiyuddin\LaravelMinio\Facades\Miniojan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestMinioController extends Controller
{
    public function index()
    {
        return view('minio');
    }

    public function store(Request $request)
    {
        dd($this->sendToMinio($request));
    }

    private function sendToMinio($request)
    {
        $file = $request->file('berkas');
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
}
