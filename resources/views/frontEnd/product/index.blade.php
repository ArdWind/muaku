@extends('customer')

@section('title', 'Produk MUA.KU')

@push('styles')
    {{-- Bootstrap 4 dari AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    {{-- Font Awesome (opsional jika butuh ikon) --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
@endpush

@section('content')
    <div class="container">
        <div class="row mt-4 justify-content-center">
            @foreach ($data as $item)
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm p-3 rounded">
                        <img src="{{ $item->product_img }}"
                            style="border-radius: 10px; max-width: 100%; height: 200px; object-fit: cover; object-position: center;"
                            alt="Gambar Produk">

                        <h5 class="fw-bold mb-0 mt-4">{{ $item->product_name }}</h5>
                        <p class="text-muted">{{ $item->description }}</p>
                        <hr>

                        <div class="d-flex justify-content-between align-items-end">
                            <div class="harga">
                                <p class="mb-0">Harga Product</p>
                                @if (intval($item->discount) > 0)
                                    @php
                                        $harga_awal = intval($item->price);
                                        $persen_diskon = intval($item->discount);
                                        $jumlah_diskon = ($persen_diskon / 100) * $harga_awal;
                                        $harga_setelah_diskon = $harga_awal - $jumlah_diskon;
                                    @endphp
                                    <div>
                                        <h6 class="mb-0">Rp <del>{{ number_format($item->price) }}</del></h6>
                                        <small class="text-danger fw-bold">
                                            {{ number_format($harga_setelah_diskon) }} ({{ $persen_diskon }}% OFF)
                                        </small>
                                    </div>
                                @else
                                    <h6>Rp {{ number_format($item->price) }}</h6>
                                @endif
                            </div>

                            <a href="#"
                                class="btn btn-primary fw-bold d-flex align-items-center justify-content-center"
                                style="height: 40px; width: 80px;">Book</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Bootstrap Bundle JS dari AdminLTE (Bootstrap 4) --}}
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
@endpush
