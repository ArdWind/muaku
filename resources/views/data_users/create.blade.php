@extends('layout.master')

@section('data')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Page Header -->
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

        <!-- Main Content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Form Edit User</h3>
                            </div>
                            <form action="{{ route('data_users.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="tel" name="Phone" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" class="form-control" required>
                                            <option value="admin">Admin</option>
                                            <option value="staff">Staff</option>
                                            <option value="customer">Customer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>

                                    <div class="form-group" hidden>
                                        <label>Status</label>
                                        <input type="text" name="Status" class="form-control" value="active" readonly
                                            hidden>
                                    </div>

                                    {{-- <div class="form-group">
                                    <label>Created Date</label>
                                    <input type="datetime-local" name="CreatedDate" class="form-control" 
                                        value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
                                </div> --}}

                                    <div class="form-group" hidden>
                                        <label>Created By</label>
                                        <input type="text" name="CreatedBy" class="form-control"
                                            value="{{ auth()->user()->name }}" readonly hidden>
                                    </div>

                                    {{-- <div class="form-group">
                                    <label>Last Updated Date</label>
                                    <input type="datetime-local" name="LastUpdatedDate" class="form-control" 
                                        value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Last Updated By</label>
                                    <input type="text" name="LastUpdatedBy" class="form-control" 
                                        value="{{ auth()->user()->name }}" readonly>
                                </div> --}}
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-success">Simpan</button>
                                    <a href="{{ url('/data-users') }}" class="btn btn-secondary px-4 ml-2">Kembali</a>
                                </div>
                            </form>
                        </div> <!-- /.card -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div> <!-- /.container-fluid -->
        </section>
    </div>
@endsection
