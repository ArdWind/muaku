@extends('layout.master')

@section('data')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Produk</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Produk</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid d-flex justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary shadow">
                    <div class="card-header text-center">
                        <h3 class="card-title">Form Edit Produk</h3>
                    </div>

                    <form action="{{ route('data_products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="form-group">
                                <label>Kode Produk</label>
                                <input type="text" name="product_code" class="form-control" value="{{ old('product_code', $product->product_code) }}" required readonly>
                            </div>

                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->product_name) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                            </div>

                            <div class="form-group">
                                <label>Gambar Produk</label><br>
                                @if ($product->product_img)
                                    <img src="{{ asset($product->product_img) }}" alt="Gambar Produk" width="100" class="mb-2">
                                @endif
                                <input type="file" name="product_img" class="form-control">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengganti gambar.</small>
                            </div>

                            <div class="form-group">
                                <label>Harga</label>
                                <input type="number" step="1" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Diskon (%)</label>
                                <input type="number" step="1" name="discount" class="form-control" value="{{ old('discount', $product->discount) }}">
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="Status" class="form-control">
                                    <option value="101" {{ $product->Status == 101 ? 'selected' : '' }}>Active</option>
                                    <option value="102" {{ $product->Status == 102 ? 'selected' : '' }}>Inactive</option>
                                    <option value="103" {{ $product->Status == 103 ? 'selected' : '' }}>Out of Stock</option>
                                    <option value="104" {{ $product->Status == 104 ? 'selected' : '' }}>Archived</option>
                                    <option value="105" {{ $product->Status == 105 ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Created Date</label>
                                <input type="datetime-local" class="form-control" value="{{ \Carbon\Carbon::parse($product->CreatedDate)->format('Y-m-d\TH:i') }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>Created By</label>
                                <input type="text" class="form-control" value="{{ $product->CreatedBy }}" disabled>
                            </div>

                            <div class="form-group">
                                <label>Last Updated Date</label>
                                <input type="datetime-local" name="LastUpdatedDate" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
                            </div>

                            <div class="form-group">
                                <label>Last Updated By</label>
                                <input type="text" name="LastUpdatedBy" class="form-control" value="{{ auth()->user()->name }}" readonly>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary px-4">Update</button>
                            <a href="{{ route('data_products.index') }}" class="btn btn-secondary px-4 ml-2">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
