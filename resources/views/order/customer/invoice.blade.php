@extends('layout.master')

@section('data')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Invoice Pesanan #{{ $order->id }}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('#') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('order.customer.pay') }}">Daftar Pesanan</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Detail Invoice</h3>
                                <div class="card-tools">
                                    {{-- Tombol untuk melihat preview PDF --}}
                                    <a href="{{ route('invoice.pdf.preview', $order->id) }}" class="btn btn-tool btn-sm"
                                        title="Preview Invoice" target="_blank">
                                        <i class="fas fa-file-pdf"></i> Preview Invoice
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (session('info'))
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        {{ session('info') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <img class="Logo1" src="/asset/cust/ico1.png" alt="Logo"
                                                    style="height: 40px; border-radius: 8px;">
                                                <small class="float-right">Tanggal:
                                                    {{ \Carbon\Carbon::parse($order->CreatedDate)->format('d/m/Y') }}</small>
                                            </h4>
                                        </div>
                                    </div>

                                    <div class="row invoice-info">
                                        <div class="col-sm-4 invoice-col">
                                            Dari
                                            <address>
                                                <strong>MUA.KU</strong><br>
                                                Perumahan Mangunjaya Lestari 2 KB 26 No 11<br>
                                                Kecamatan Tambun Selatan, Kabupaten Bekasi<br>
                                                Telp: +62 896-7390-6621<br>
                                                Email: youvandamaysha@gmail.com
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            Kepada
                                            <address>
                                                <strong>{{ $order->CustomerName }}</strong><br>
                                                {{ $order->Address }}<br>
                                                Telp: {{ $order->Phone }}<br>
                                                Email: {{ Auth::user()->email ?? 'N/A' }}
                                            </address>
                                        </div>
                                        <div class="col-sm-4 invoice-col">
                                            <b>Invoice #{{ $order->InvoiceNumber }}</b><br>
                                            <br>
                                            <b>Order ID:</b> {{ $order->id }}<br>
                                            <b>Tanggal Booking:</b>
                                            {{ \Carbon\Carbon::parse($order->BookingDate)->format('d M Y') }}<br>
                                            <b>Status Order:</b>
                                            <span
                                                class="badge {{ $order->OrderStatus == 'Approved' ? 'badge-success' : ($order->OrderStatus == 'Waiting Approval' ? 'badge-warning' : 'badge-danger') }}">{{ $order->OrderStatus }}</span><br>
                                            <b>Status Pembayaran:</b>
                                            @php
                                                $paymentStatusClass = '';
                                                switch ($order->PaymentStatus) {
                                                    case 'Paid':
                                                        $paymentStatusClass = 'badge-success';
                                                        break;
                                                    case 'Unpaid':
                                                        $paymentStatusClass = 'badge-warning';
                                                        break;
                                                    case 'Failed':
                                                        $paymentStatusClass = 'badge-danger';
                                                        break;
                                                    default:
                                                        $paymentStatusClass = 'badge-secondary'; // Default jika status tidak dikenal
                                                        break;
                                                }
                                            @endphp
                                            <span
                                                class="badge {{ $paymentStatusClass }}">{{ $order->PaymentStatus }}</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Qty</th>
                                                        <th>Produk</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $order->Quantity }}</td>
                                                        <td>{{ $order->Product }}</td>
                                                        <td>Rp
                                                            {{ number_format($order->TotalPrice / $order->Quantity, 0, ',', '.') }}
                                                        </td>
                                                        <td>Rp {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <p class="lead">Catatan:</p>
                                            <p class="text-muted well well-sm shadow-none" style="margin-top: 5px;">
                                                Terima kasih atas kepercayaan Anda memilih layanan <strong>MUA.KU</strong>
                                                untuk momen
                                                spesial Anda.
                                            <ul style="font-size: small;">
                                                <li>Mohon lakukan pembayaran sesuai dengan total invoice sebelum tanggal
                                                    yang disepakati.</li>
                                                <li>Untuk <strong>perubahan jadwal</strong> atau informasi lainnya, harap
                                                    hubungi kami
                                                    maksimal <strong>7 hari</strong> sebelum hari H.</li>
                                                <li><strong>Pembatalan pesanan</strong> kurang dari <strong>3 hari</strong>
                                                    sebelum hari H akan
                                                    dikenakan biaya <strong>50%</strong> dari total biaya.</li>
                                                <li>Harga dapat disesuaikan jika ada permintaan <strong>tambahan
                                                        layanan</strong> di luar
                                                    paket yang disepakati.</li>
                                                <li>Pastikan area kerja (lokasi makeup) memiliki <strong>pencahayaan yang
                                                        baik</strong>
                                                    dan <strong>ruang yang cukup</strong>.</li>
                                            </ul>
                                            Kami berharap dapat menjadi bagian yang tak terlupakan dalam hari bahagia Anda!
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <p class="lead">Jumlah Total:</p>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td>Rp {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total:</th>
                                                        <td>Rp {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->role === 'customer')
                                <div class="card-footer text-right">
                                    <a href="{{ route('order.customer.pay') }}" class="btn btn-secondary"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                @elseif (Auth::user()->role === 'staff')
                                    <div class="card-footer text-right">
                                        <a href="{{ route('order.staff.index') }}" class="btn btn-secondary"><i
                                                class="fas fa-arrow-left"></i> Kembali</a>
                            @endif
                            {{-- Tombol untuk Customer --}}
                            @if (Auth::user()->role === 'customer')
                                @if ($order->OrderStatus == 'Waiting Approval')
                                    <span class="badge badge-info ml-2">Menunggu Persetujuan Staff</span>
                                @elseif ($order->OrderStatus == 'Approved' && $order->PaymentStatus == 'Unpaid')
                                    {{-- Order approved, but payment is outstanding --}}
                                    <a href="{{ route('order.initiate_payment', $order->id) }}"
                                        class="btn btn-success ml-2">
                                        <i class="fas fa-credit-card"></i> Bayar Sekarang
                                    </a>
                                @elseif ($order->PaymentStatus == 'Paid')
                                    <span class="badge badge-success ml-2">Pembayaran Selesai</span>
                                @elseif ($order->PaymentStatus == 'Failed' || $order->OrderStatus == 'Rejected')
                                    {{-- Payment failed or order rejected --}}
                                    <span class="badge badge-danger ml-2">Pesanan Dibatalkan / Pembayaran Gagal</span>
                                @else
                                    {{-- Fallback for any other unexpected state --}}
                                    <span class="badge badge-secondary ml-2">Status Pesanan: {{ $order->OrderStatus }}
                                        (Pembayaran: {{ $order->PaymentStatus }})</span>
                                @endif
                            @endif

                            {{-- Tombol untuk Staff --}}
                            @if (Auth::user()->role === 'staff')
                                @if ($order->OrderStatus == 'Waiting Approval')
                                    <form action="{{ route('order.staff.update_status', $order->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        <input type="hidden" name="status" value="Approved">
                                        <button type="submit" class="btn btn-success ml-2">
                                            <i class="fas fa-check"></i> Setujui Pesanan
                                        </button>
                                    </form>
                                    <form action="{{ route('order.staff.update_status', $order->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        <input type="hidden" name="status" value="Rejected">
                                        <button type="submit" class="btn btn-danger ml-2">
                                            <i class="fas fa-times"></i> Tolak Pesanan
                                        </button>
                                    </form>
                                @elseif ($order->OrderStatus == 'Approved' && $order->PaymentStatus == 'Unpaid')
                                    <span class="badge badge-info ml-2">Menunggu Pembayaran dari Pelanggan</span>
                                @elseif ($order->OrderStatus == 'Approved' && $order->PaymentStatus == 'Paid')
                                    <span class="badge badge-success ml-2">Pesanan & Pembayaran Selesai</span>
                                @elseif ($order->OrderStatus == 'Rejected')
                                    <span class="badge badge-danger ml-2">Pesanan Ditolak</span>
                                @elseif ($order->PaymentStatus == 'Failed')
                                    <span class="badge badge-danger ml-2">Pembayaran Gagal / Dibatalkan</span>
                                @else
                                    <span class="badge badge-secondary ml-2">Status Tidak Dikenal:
                                        {{ $order->OrderStatus }} (Pembayaran: {{ $order->PaymentStatus }})</span>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script> --}}
@endsection
