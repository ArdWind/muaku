@extends('layout.master')

@section('data')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>DataTables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">DataTable all Product</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="tabel2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Harga</th>
                                            <th>Disc(%)</th>
                                            <th>Status</th>
                                            <th>Gambar</th>
                                            <th>Created</th>
                                            <th>Created By</th>
                                            <th>Updated</th>
                                            <th>Updated By</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            @php
                                                $statusLabels = [
                                                    101 => 'Active',
                                                    102 => 'Inactive',
                                                    103 => 'Out of Stock',
                                                    104 => 'Archived',
                                                    105 => 'Draft',
                                                ];
                                            @endphp
                                            <tr>
                                                <td>{{ $product->product_code }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ number_format($product->price) }}</td>
                                                <td>{{ $product->discount }}</td>
                                                <td>{{ $statusLabels[$product->Status] ?? 'Unknown' }}</td>
                                                {{-- <td>{{ $product->Status == 100 ? 'Aktif' : 'Nonaktif' }}</td> --}}
                                                <td>
                                                    @if ($product->product_img)
                                                        <img src="{{ asset($product->product_img) }}" alt="Product Image"
                                                            width="50">
                                                    @endif
                                                </td>
                                                <td>{{ $product->CreatedDate }}</td>
                                                <td>{{ $product->CreatedBy }}</td>
                                                <td>{{ $product->LastUpdatedDate }}</td>
                                                <td>{{ $product->LastUpdatedBy }}</td>
                                                <td>
                                                    <a href="{{ route('data_products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('data_products.destroy', $product->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Yakin hapus produk ini?')"
                                                            title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Bootstrap CDN sebagai alternatif -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <!-- DataTables  & Plugins -->
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
    <!-- AdminLTE App -->
    {{-- <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script> --}}

    <!-- Page specific script -->
    {{-- <script>
  $(function () {
    const commonOptions = {
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
    };

    const tabel1 = $("#tabel1").DataTable(commonOptions);
    tabel1.buttons().container().appendTo('#tabel1_wrapper .col-md-6:eq(0)');

    const tabel2 = $("#tabel2").DataTable(commonOptions);
    tabel2.buttons().container().appendTo('#tabel2_wrapper .col-md-6:eq(0)');
  });
</script> --}}

    <script>
        $(function() {
            // Konfigurasi umum untuk semua DataTable
            const commonOptions = {
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            };

            // Fungsi untuk membuat DataTable dengan tombol "Add New"
            function createDataTableWithAddButton(selector, createUrl, buttonLabel = 'Add New') {
                const table = $(selector).DataTable({
                    ...commonOptions,
                    buttons: [{
                            text: buttonLabel,
                            className: 'btn btn-success',
                            action: function() {
                                window.location.href = createUrl;
                            }
                        },
                        "copy", "csv", "excel", "pdf", "print", "colvis"
                    ]
                });

                // Menempatkan tombol di posisi yang benar
                table.buttons().container().appendTo(`${selector}_wrapper .col-md-6:eq(0)`);
            }

            // Contoh penggunaan untuk dua tabel berbeda
            createDataTableWithAddButton('#tabel2', "{{ route('data_products.create') }}", 'Add New Product');
        });
    </script>
@endsection
