@extends('layout.master')

@section('data')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tambah User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Tambah User</li>
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
                                <h3 class="card-title">Form Tambah User Baru</h3> {{-- Mengubah judul dari Edit menjadi Tambah --}}
                            </div>
                            <form action="{{ route('data_users.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="row"> {{-- Baris baru untuk Nama dan Email --}}
                                        <div class="col-md-6"> {{-- Kolom untuk Nama --}}
                                            <div class="form-group">
                                                <label for="name">Nama</label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> {{-- Kolom untuk Email --}}
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row"> {{-- Baris baru untuk Phone dan Role --}}
                                        <div class="col-md-6"> {{-- Kolom untuk Phone --}}
                                            <div class="form-group">
                                                <label for="phone">Phone</label>
                                                <input type="tel" name="Phone" id="phone" class="form-control"
                                                    required> {{-- Ubah name menjadi "phone" (huruf kecil) --}}
                                            </div>
                                        </div>
                                        <div class="col-md-6"> {{-- Kolom untuk Role --}}
                                            <div class="form-group">
                                                <label for="role">Role</label>
                                                <select name="role" id="role" class="form-control" required>
                                                    <option value="admin">Admin</option>
                                                    <option value="staff">Staff</option>
                                                    <option value="customer">Customer</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Password dan Konfirmasi Password tetap di bawah, mengambil lebar penuh --}}
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" required>
                                    </div>

                                    {{-- Field tersembunyi --}}
                                    <div class="form-group" hidden>
                                        <label>Status</label>
                                        <input type="text" name="Status" class="form-control" value="active" readonly>
                                    </div>

                                    <div class="form-group" hidden>
                                        <label>Created By</label>
                                        <input type="text" name="CreatedBy" class="form-control"
                                            value="{{ auth()->user()->name }}" readonly>
                                    </div>

                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <a href="{{ url('/data-users') }}" class="btn btn-secondary px-4 ml-2">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
