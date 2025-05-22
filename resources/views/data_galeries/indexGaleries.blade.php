@extends('layout.master')

@section('data')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Gallery</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Gallery</li>
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
                                <h3 class="card-title">Data Gallery</h3>
                            </div>
                            <div class="card-body">
                                <table id="tabel2" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Aksi</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Gambar</th>
                                            <th>Created</th>
                                            <th>Created By</th>
                                            <th>Updated</th>
                                            <th>Updated By</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($galleries as $gallery)
                                            @php
                                                $statusLabels = [
                                                    101 => 'Active',
                                                    102 => 'Inactive',
                                                    103 => 'Hidden',
                                                    104 => 'Archived',
                                                ];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ route('data_galeries.edit', $gallery->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('data_galeries.destroy', $gallery->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Yakin hapus galeri ini?')"
                                                            title="Hapus">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                                <td>{{ $gallery->name }}</td>
                                                <td>{{ $gallery->category }}</td>
                                                <td style="height: 50px;">
                                                    @php
                                                        $extension = pathinfo($gallery->image_path, PATHINFO_EXTENSION);
                                                    @endphp

                                                    @if (in_array($extension, ['mp4', 'webm', 'ogg']))
                                                        <div onclick="playVideo(this)"
                                                            style="cursor: pointer; position: relative; display: flex; align-items: center; justify-content: center; height: 100%; max-height: 60px;">
                                                            <i class="fas fa-play-circle"
                                                                style="color: black; font-size: 20px; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2;"></i>
                                                            <video style="display: none; height: 100%; width: auto;"
                                                                controls>
                                                                <source src="{{ asset($gallery->image_path) }}"
                                                                    type="video/{{ $extension }}">
                                                            </video>
                                                        </div>
                                                    @elseif ($gallery->image_path)
                                                        <div
                                                            style="display: flex; align-items: center; justify-content: center; height: 60px;">
                                                            <img src="{{ asset($gallery->image_path) }}" alt="Gallery Image"
                                                                style="max-height: 60px; width: auto;">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $gallery->CreatedDate }}</td>
                                                <td>{{ $gallery->CreatedBy }}</td>
                                                <td>{{ $gallery->LastUpdatedDate }}</td>
                                                <td>{{ $gallery->LastUpdatedBy }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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

    <script>
        $(function() {
            const commonOptions = {
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
            };

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

                table.buttons().container().appendTo(`${selector}_wrapper .col-md-6:eq(0)`);
            }

            createDataTableWithAddButton('#tabel2', "{{ route('data_galeries.create') }}", 'Add New Gallery');
        });
    </script>
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
