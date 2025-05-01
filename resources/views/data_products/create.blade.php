@extends('layout.master')

@section('data')
<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Page Header -->
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

    <!-- Main Content -->
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
                                <div class="form-group">
                                    <label>Kode Produk</label>
                                    <input type="text" name="product_code" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" name="product_name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label>Gambar Produk</label>
                                    <input type="file" name="product_img" class="form-control-file">
                                </div>

                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" name="price" class="form-control" step="0.01" required>
                                </div>

                                <div class="form-group">
                                    <label>Diskon (%)</label>
                                    <input type="number" name="discount" class="form-control" step="0.01" value="0">
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="Status" class="form-control">
                                        <option value="101">Active</option>
                                        <option value="102">Inactive</option>
                                        <option value="103">Out of Stock</option>
                                        <option value="104">Archived</option>
                                        <option value="105">Draft</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Created Date</label>
                                    <input type="datetime-local" name="CreatedDate" class="form-control"
                                        value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Created By</label>
                                    <input type="text" name="CreatedBy" class="form-control"
                                        value="{{ auth()->user()->name }}" readonly>
                                </div>
                                
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-success">Simpan</button>
                                <a href="{{ url('/data-products') }}" class="btn btn-secondary px-4 ml-2">Kembali</a>
                            </div>
                        </form>
                    </div> <!-- /.card -->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </section>
</div>
@endsection
