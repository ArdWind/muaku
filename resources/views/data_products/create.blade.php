@extends('layout.master')

@section('data')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Produk</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Produk</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form Tambah Produk</h3>
                            </div>
                            <form action="{{ route('data_products.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    {{-- Baris untuk Kode Produk dan Nama Produk --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_code">Kode Produk</label>
                                                <input type="text" name="product_code" id="product_code"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="product_name">Nama Produk</label>
                                                <input type="text" name="product_name" id="product_name"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Gambar Produk tetap di baris terpisah --}}
                                    <div class="form-group">
                                        <label for="product_img">Gambar Produk</label>
                                        <input type="file" name="product_img" id="product_img" class="form-control-file">
                                    </div>

                                    {{-- Baris untuk Harga dan Diskon --}}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="price">Harga</label>
                                                <input type="number" name="price" id="price" class="form-control"
                                                    step="0.01" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="discount">Diskon (%)</label>
                                                <input type="number" name="discount" id="discount" class="form-control"
                                                    step="0.01" value="0">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Deskripsi tetap di baris terpisah --}}
                                    <div class="form-group">
                                        <label for="description">Deskripsi</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                    </div>

                                    {{-- Status tetap di baris terpisah --}}
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="Status" id="status" class="form-control">
                                            <option value="101">Active</option>
                                            <option value="102">Inactive</option>
                                            <option value="103">Out of Stock</option>
                                            <option value="104">Archived</option>
                                            <option value="105">Draft</option>
                                        </select>
                                    </div>

                                    {{-- Created Date dan Created By Dihapus dari Form --}}
                                    {{-- Karena akan ditangani oleh controller --}}

                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <a href="{{ url('/data-products') }}" class="btn btn-secondary px-4 ml-2">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
