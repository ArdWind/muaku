@extends('customer') {{-- Asumsikan Anda menggunakan layout 'customer' --}}

@section('title', 'Form Pemesanan Layanan')

@push('styles')
    {{-- Bootstrap 4 dari AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    {{-- Font Awesome (opsional jika butuh ikon) --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
@endpush

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm p-4 rounded">
                    <h2 class="card-title text-center mb-4 display-5 fw-bold">Konfirmasi Pemesanan Layanan</h2>
                    <hr class="w-50 mx-auto my-4">

                    <form action="{{ route('order.store') }}" method="POST">
                        @csrf

                        {{-- Input tersembunyi untuk ID Produk --}}
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        {{-- Input tersembunyi untuk harga produk dasar (setelah diskon) --}}
                        @php
                            $displayed_price = $product->price;
                            if (intval($product->discount) > 0) {
                                $harga_awal = intval($product->price);
                                $persen_diskon = intval($product->discount);
                                $jumlah_diskon = ($persen_diskon / 100) * $harga_awal;
                                $displayed_price = $harga_awal - $jumlah_diskon;
                            }
                        @endphp
                        <input type="hidden" id="product_base_price" value="{{ $displayed_price }}">


                        {{-- Field Nama Produk (Otomatis Terisi dari produk yang dipilih) --}}
                        <div class="form-group mb-3">
                            <label for="product_name">Nama Layanan:</label>
                            <input type="text" class="form-control" id="product_name" name="product_name"
                                value="{{ $product->product_name }}" readonly>
                        </div>

                        {{-- Field Customer Name (Otomatis Terisi dari akun aktif) --}}
                        <div class="form-group mb-3">
                            <label for="CustomerName">Nama Pelanggan:</label>
                            <input type="text" class="form-control" id="CustomerName" name="CustomerName"
                                value="{{ $customerName ?? '' }}" readonly>
                            {{-- Jika $customerName tidak tersedia (belum login), biarkan kosong atau berikan pesan --}}
                        </div>

                        {{-- Field Phone (Otomatis Terisi dari akun aktif) --}}
                        <div class="form-group mb-3">
                            <label for="Phone">Nomor Telepon:</label>
                            <input type="text" class="form-control" id="Phone" name="Phone"
                                value="{{ $phoneNumber ?? '' }}" readonly>
                            {{-- Jika $phoneNumber tidak tersedia, biarkan kosong --}}
                        </div>

                        {{-- Field Address --}}
                        <div class="form-group mb-3">
                            <label for="Address">Alamat Lengkap:</label>
                            <textarea class="form-control" id="Address" name="Address" rows="3" required autofocus>{{ $customerAddress ?? '' }}</textarea>
                            {{-- Jika $customerAddress tidak tersedia, biarkan kosong --}}
                        </div>

                        {{-- Field Quantity --}}
                        <div class="form-group mb-3">
                            <label for="Quantity">Jumlah:</label>
                            <input type="number" class="form-control" id="Quantity" name="Quantity" value="1"
                                min="1" required>
                        </div>

                        {{-- Field BookingDate (BARU) --}}
                        <div class="form-group mb-3">
                            <label for="BookingDate">Tanggal Booking:</label>
                            <input type="date" class="form-control" id="BookingDate" name="BookingDate" required>
                            {{-- Anda bisa menambahkan value default jika perlu, misal: value="{{ date('Y-m-d') }}" --}}
                        </div>

                        {{-- Field Total Harga (Otomatis Terisi dan Update Dinamis) --}}
                        <div class="form-group mb-3">
                            <label for="TotalPrice">Total Harga:</label>
                            <input type="text" class="form-control font-weight-bold" id="TotalPriceDisplay"
                                value="Rp {{ number_format($displayed_price) }}" readonly>
                            {{-- Input hidden untuk mengirim nilai numerik TotalPrice ke controller --}}
                            <input type="hidden" name="TotalPrice" id="TotalPriceHidden" value="{{ $displayed_price }}">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            {{-- Tombol Cancel --}}
                            <button type="button" class="btn btn-secondary fw-bold py-2 w-50 mr-2"
                                onclick="window.history.back()">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary fw-bold py-2 w-50 ml-2">Pesan Sekarang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Bootstrap Bundle JS dari AdminLTE (Bootstrap 4) --}}
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInput = document.getElementById('Quantity');
            const productBasePrice = parseFloat(document.getElementById('product_base_price').value);
            const totalPriceDisplay = document.getElementById('TotalPriceDisplay');
            const totalPriceHidden = document.getElementById('TotalPriceHidden');

            function calculateTotalPrice() {
                let quantity = parseInt(quantityInput.value);
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1; // Pastikan kuantitas minimal 1
                    quantityInput.value = 1;
                }

                const total = productBasePrice * quantity;
                totalPriceDisplay.value = 'Rp ' + total.toLocaleString('id-ID'); // Format ke Rupiah
                totalPriceHidden.value = total; // Simpan nilai numerik untuk submission
            }

            // Panggil saat halaman pertama kali dimuat
            calculateTotalPrice();

            // Tambahkan event listener untuk memanggil fungsi saat Quantity berubah
            quantityInput.addEventListener('input', calculateTotalPrice);
        });
    </script>
@endpush
