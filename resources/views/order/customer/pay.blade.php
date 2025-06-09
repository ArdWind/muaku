@extends('layout.master')

@section('data')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Pemesanan Anda</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/customer') }}">Home</a></li>
                            <li class="breadcrumb-item active">Daftar Pemesanan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tabel Pesanan Saya</h3>
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
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                @if ($orders->isEmpty())
                                    <div class="alert alert-info text-center" role="alert">
                                        Anda belum memiliki pemesanan. <a href="{{ route('products.index') }}">Mulai pesan
                                            sekarang!</a>
                                    </div>
                                @else
                                    <table id="myOrdersTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 80px;">Aksi</th>
                                                <th>Order ID</th> {{-- Kolom Order ID ditambahkan kembali --}}
                                                <th>No. Invoice</th>
                                                <th>Nama Pelanggan</th>
                                                <th>Produk</th>
                                                <th>Kuantitas</th>
                                                <th>Total Harga</th>
                                                <th>Tgl. Booking</th>
                                                <th>Status Order</th>
                                                <th>Status Pembayaran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('order.customer.invoice', $order->id) }}"
                                                            class="btn btn-sm btn-info" title="Lihat Invoice">
                                                            <i class="fas fa-file-invoice"></i> Invoice
                                                        </a>
                                                    </td>
                                                    <td>{{ $order->id }}</td> {{-- Menampilkan Order ID --}}
                                                    <td>{{ $order->InvoiceNumber }}</td>
                                                    <td>{{ $order->CustomerName }}</td>
                                                    <td>{{ $order->Product }}</td>
                                                    <td>{{ $order->Quantity }}</td>
                                                    <td>Rp {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($order->BookingDate)->format('d F Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($order->OrderStatus == 'Waiting Approval')
                                                            <span class="badge badge-warning">Menunggu Persetujuan</span>
                                                        @elseif ($order->OrderStatus == 'Approved')
                                                            <span class="badge badge-success">Disetujui</span>
                                                        @elseif ($order->OrderStatus == 'Rejected')
                                                            <span class="badge badge-danger">Ditolak</span>
                                                        @else
                                                            {{-- Fallback for any unexpected state --}}
                                                            <span class="badge badge-secondary">Status Tidak Dikenal</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($order->PaymentStatus == 'Unpaid')
                                                            <span class="badge badge-warning">Belum Dibayar</span>
                                                        @elseif ($order->PaymentStatus == 'Paid')
                                                            <span class="badge badge-success">Sudah Dibayar</span>
                                                        @elseif ($order->PaymentStatus == 'Failed')
                                                            <span class="badge badge-danger">Gagal</span>
                                                        @else
                                                            {{-- Fallback for any unexpected state --}}
                                                            <span class="badge badge-secondary">Status Tidak Dikenal</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    {{-- <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script> --}}

    <script>
        $(function() {
            $("#myOrdersTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                "order": [
                    [1, "desc"]
                ] // Urutkan berdasarkan kolom "Order ID" (indeks 1) secara descending
            }).buttons().container().appendTo('#myOrdersTable_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
