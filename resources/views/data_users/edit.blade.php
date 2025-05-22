@extends('layout.master')

@section('data')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit User</li>
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
                            <h3 class="card-title">Form Edit User</h3>
                        </div>

                        <form action="{{ route('data_users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                {{-- <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                                </div> --}}

                                <div class="row">
                                    <div class="col-sm-6"> {{-- Atur lebar kolom sesuai kebutuhan, contoh: col-sm-6 untuk setengah lebar --}}
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"> {{-- Atur lebar kolom sesuai kebutuhan, contoh: col-sm-6 untuk setengah lebar --}}
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" value="{{ $user->email }}" class="form-control" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="tel" name="Phone" value="{{ $user->Phone }}" class="form-control"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" class="form-control" required>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff</option>
                                        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="Status" class="form-control">
                                        <option value="active" {{ $user->Status == 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="banned" {{ $user->Status == 'banned' ? 'selected' : '' }}>Banned
                                        </option>
                                    </select>
                                </div>

                                {{-- <div class="form-group">
                                    <label>Created Date</label>
                                    <input type="datetime-local"
                                        value="{{ \Carbon\Carbon::parse($user->CreatedDate)->format('Y-m-d\TH:i') }}"
                                        class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Created By</label>
                                    <input type="text" value="{{ $user->CreatedBy }}" class="form-control" disabled>
                                </div>

                                <div class="form-group">
                                    <label>Last Updated Date</label>
                                    <input type="datetime-local" name="LastUpdatedDate"
                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" class="form-control"
                                        readonly>
                                </div>

                                <div class="form-group">
                                    <label>Last Updated By</label>
                                    <input type="text" name="LastUpdatedBy" value="{{ auth()->user()->name }}"
                                        class="form-control" readonly>
                                </div>
                            </div> --}}

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary px-4">Update</button>
                                    <button type="button" class="btn btn-info px-4 ml-2"
                                        onclick="window.print()">Print</button>
                                    <a href="{{ url('/data-users') }}" class="btn btn-secondary px-4 ml-2">Kembali</a>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <style>
        @media print {

            .main-header,
            .content-header,
            .breadcrumb,
            .card-footer,
            .btn {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
@endsection
