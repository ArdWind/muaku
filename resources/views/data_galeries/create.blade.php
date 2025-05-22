@extends('layout.master')

@section('data')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Page Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah Galeri</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah Galeri</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form Tambah Galeri</h3>
                            </div>
                            <form action="{{ route('data_galeries.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    {{-- Nama --}}
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Kategori --}}
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select name="category" class="form-control @error('category') is-invalid @enderror"
                                            required>
                                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih
                                                Kategori</option>
                                            <option value="WEDDING" {{ old('category') == 'WEDDING' ? 'selected' : '' }}>
                                                WEDDING</option>
                                            <option value="BRIDESMAID"
                                                {{ old('category') == 'BRIDESMAID' ? 'selected' : '' }}>BRIDESMAID</option>
                                            <option value="ENGAGEMENT DAY"
                                                {{ old('category') == 'ENGAGEMENT DAY' ? 'selected' : '' }}>ENGAGEMENT DAY
                                            </option>
                                            <option value="GRADUATION"
                                                {{ old('category') == 'GRADUATION' ? 'selected' : '' }}>GRADUATION</option>
                                        </select>
                                        @error('category')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Gambar --}}
                                    <div class="form-group">
                                        <label>Gambar</label>
                                        <input type="file" name="image"
                                            class="form-control-file @error('image') is-invalid @enderror" required>
                                        @error('image')
                                            <span class="invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Created By (readonly) --}}
                                    {{-- <div class="form-group">
                                    <label>Created By</label>
                                    <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                                </div> --}}

                                    {{-- Created Date (readonly) --}}
                                    {{-- <div class="form-group">
                                    <label>Created Date</label>
                                    <input type="datetime-local" class="form-control" 
                                        value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
                                </div> --}}

                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <a href="{{ route('data_galeries.index') }}"
                                        class="btn btn-secondary px-4 ml-2">Kembali</a>
                                </div>
                            </form>
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div> <!-- /.container-fluid -->
        </section>
    </div>
@endsection
