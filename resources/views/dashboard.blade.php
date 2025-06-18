@extends('layout.master')

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard v1</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $totalNewOrders }}</h3>
                                <p>New Orders (Unpaid)</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route('order.staff.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $totalApprovedOrders }}</h3>
                                <p>Approved Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-checkmark-round"></i>
                            </div>
                            <a href="{{ route('order.staff.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $totalUserRegistrations }}</h3>
                                <p>User Registrations</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route('data_users.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totalProducts }}</h3>
                                <p>Total Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-cube"></i>
                            </div>
                            <a href="{{ route('data_products.index') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Monthly Revenue ({{ \Carbon\Carbon::now()->year }})
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button> --}}
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="revenueChartCanvas"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-clipboard mr-1"></i>
                                    Latest New Orders (Waiting Approval)
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                      <i class="fas fa-times"></i>
                                  </button> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <th>Customer Name</th>
                                            <th>Product</th>
                                            <th>Booking Date</th>
                                            <th>Total Price</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestNewOrders as $order)
                                            <tr>
                                                <td>{{ $order->InvoiceNumber }}</td>
                                                <td>{{ $order->CustomerName }}</td>
                                                <td>{{ $order->Product }}</td>
                                                <td>{{ \Carbon\Carbon::parse($order->BookingDate)->format('d M Y') }}</td>
                                                <td>Rp. {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
                                                <td><span class="badge badge-secondary">{{ $order->OrderStatus }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No new orders found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="{{ route('order.staff.index') }}" class="btn btn-primary float-right">View All
                                    Orders <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="ion ion-person-add mr-1"></i>
                                    Latest User Registrations
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                      <i class="fas fa-times"></i>
                                  </button> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Registration Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestUserRegistrations as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td><span class="badge badge-info">{{ $user->role }}</span></td>
                                                <td>{{ \Carbon\Carbon::parse($user->CreatedDate)->format('d M Y H:i') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No recent user registrations found.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer clearfix">
                                <a href="{{ route('data_users.index') }}" class="btn btn-primary float-right">View All
                                    Users <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </section>
                    <section class="col-lg-5 connectedSortable">
                        <div class="card bg-gradient-success">
                            <div class="card-header border-0">
                                <h3 class="card-title">
                                    <i class="far fa-calendar-alt"></i>
                                    Calendar
                                </h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- <button type="button" class="btn btn-tool" data-card-widget="remove">
                                      <i class="fas fa-times"></i>
                                  </button> --}}
                                </div>
                                {{-- Menghilangkan tombol pengaturan kalender --}}
                                {{-- <div class="card-tools">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                            data-toggle="dropdown" data-offset="-52">
                                            <i class="fas fa-bars"></i>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                            <a href="#" class="dropdown-item">Add new event</a>
                                            <a href="#" class="dropdown-item">Clear events</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item">View calendar</a>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div> --}}
                            </div>
                            <div class="card-body pt-0">
                                <div id="calendar" style="width: 100%"></div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    {{-- PASTI ADA INI: Pastikan FullCalendar JS dimuat --}}
    {{-- Lokasi mungkin berbeda tergantung versi AdminLTE Anda --}}
    <script src="{{ asset('adminlte/plugins/fullcalendar/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-daygrid/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-timegrid/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-interaction/main.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/fullcalendar-bootstrap/main.min.js') }}"></script>

    <script src="{{ asset('adminlte/dist/js/pages/dashboard.js') }}"></script>

    {{-- Script kustom untuk FullCalendar --}}
    <script>
        $(function() {
            var calendarEl = document.getElementById('calendar');
            var Calendar = FullCalendar.Calendar;

            // Pastikan data ini tidak kosong setelah debugging controller
            var calendarEvents = @json($calendarEvents);

            // console.log(calendarEvents); // Buka komentar ini untuk melihat data di konsol browser

            var calendar = new Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,dayGridDay'
                },
                themeSystem: 'bootstrap',
                events: calendarEvents, // Data events dari controller
                editable: false,
                droppable: false,
                eventClick: function(info) {
                    if (info.event.url) {
                        window.open(info.event.url, "_self"); // Buka di tab baru
                        return false;
                    }
                }
            });

            calendar.render();

            // PENTING: Hapus atau komentari baris inisialisasi datetimepicker ini
            // Karena ini untuk date picker, bukan event calendar
            /*
            $('#calendar').datetimepicker({
                format: 'L',
                inline: true
            });
            */

            // --- Inisialisasi Chart.js untuk Monthly Revenue ---
            var revenueChartCanvas = document.getElementById('revenueChartCanvas');
            if (revenueChartCanvas) { // Periksa apakah elemen canvas ditemukan
                var ctx = revenueChartCanvas.getContext('2d');

                var revenueChartData = {
                    labels: @json($months), // Data bulan dari controller
                    datasets: [{
                        label: 'Revenue',
                        backgroundColor: 'rgba(60,141,188,0.9)', // Warna biru AdminLTE
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: @json($revenues) // Data pendapatan dari controller
                    }]
                };

                var revenueChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                        display: false // Sembunyikan legenda
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                display: false
                            },
                            ticks: {
                                beginAtZero: true, // Mulai sumbu Y dari 0
                                callback: function(value, index, values) {
                                    // Format mata uang Rupiah
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }]
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + tooltipItem.yLabel.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                };

                // Buat grafik area/line
                new Chart(ctx, {
                    type: 'line', // Gunakan 'line' untuk grafik area, atau 'bar' jika ingin bar chart
                    data: revenueChartData,
                    options: revenueChartOptions
                });
            } else {
                console.warn("Canvas element with ID 'revenueChartCanvas' not found for Chart.js.");
            }
        });
    </script>
@endsection
