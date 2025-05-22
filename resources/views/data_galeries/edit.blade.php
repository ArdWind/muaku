@extends('layout.master')

@section('data')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Galeri</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Edit Galeri</li>
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
                            <h3 class="card-title">Form Edit Galeri</h3>
                        </div>

                        <form action="{{ route('data_galeries.update', $gallery->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Nama Galeri</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $gallery->name) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <select name="category"
                                                class="form-control @error('category') is-invalid @enderror" required>
                                                <option value="" disabled
                                                    {{ old('category', $gallery->category) ? '' : 'selected' }}>
                                                    Pilih Kategori
                                                </option>
                                                @foreach (['WEDDING', 'BRIDESMAID', 'ENGAGEMENT DAY', 'GRADUATION'] as $option)
                                                    <option value="{{ $option }}"
                                                        {{ old('category', $gallery->category) === $option ? 'selected' : '' }}>
                                                        {{ $option }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Gambar Galeri</label><br>
                                    @php
                                        $extension = pathinfo($gallery->image_path, PATHINFO_EXTENSION);
                                    @endphp

                                    <div
                                        style="display: flex; align-items: center; justify-content: center; height: 200px;">
                                        @if (in_array($extension, ['mp4', 'webm', 'ogg']))
                                            <div onclick="playVideo(this)" style="cursor: pointer; position: relative;">
                                                <i class="fas fa-play-circle"
                                                    style="color: black; font-size: 48px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2;"></i>
                                                <video style="display: none; max-height: 200px; max-width: 100%;" controls>
                                                    <source src="{{ asset($gallery->image_path) }}"
                                                        type="video/{{ $extension }}">
                                                </video>
                                            </div>
                                        @elseif ($gallery->image_path)
                                            <img src="{{ asset($gallery->image_path) }}" alt="Gallery Image"
                                                style="max-height: 200px; width: auto;">
                                        @endif
                                    </div>

                                    <input type="file" name="image" class="form-control mt-2">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti
                                        gambar/video.</small>
                                </div>

                                {{-- Metadata --}}
                                {{-- <div class="form-group">
                                    <label>Created Date</label>
                                    <input type="datetime-local" class="form-control"
                                        value="{{ \Carbon\Carbon::parse($gallery->CreatedDate)->format('Y-m-d\TH:i') }}"
                                        disabled>
                                </div>

                                <div class="form-group">
                                    <label>Created By</label>
                                    <input type="text" class="form-control" value="{{ $gallery->CreatedBy }}" disabled>
                                </div> --}}

                                {{-- <div class="form-group">
                                    <label>Last Updated Date</label>
                                    <input type="datetime-local" name="LastUpdatedDate" class="form-control"
                                        value="{{ now()->format('Y-m-d\TH:i') }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Last Updated By</label>
                                    <input type="text" name="LastUpdatedBy" class="form-control"
                                        value="{{ auth()->user()->name }}" readonly>
                                </div>
                            </div> --}}

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary px-4">Update</button>
                                    <button type="button" class="btn btn-info px-4 ml-2"
                                        onclick="window.print()">Print</button>
                                    <a href="{{ route('data_galeries.index') }}"
                                        class="btn btn-secondary px-4 ml-2">Kembali</a>
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
            .btn,
            input[type="file"],
            small.text-muted {
                display: none !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            img {
                max-width: 200px !important;
                height: auto !important;
            }

            .form-control:disabled,
            .form-control[readonly] {
                background-color: transparent !important;
                border: none !important;
                box-shadow: none !important;
            }
        }
    </style>
    <script>
        function playVideo(container) {
            const icon = container.querySelector('i');
            const video = container.querySelector('video');

            icon.style.display = 'none';
            video.style.display = 'block';
            video.play();
        }
    </script>
@endsection
