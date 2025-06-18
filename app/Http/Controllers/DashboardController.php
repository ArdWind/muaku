<?php

namespace App\Http\Controllers;

use App\Models\Order; // Pastikan Anda mengimpor model Order Anda
use App\Models\User;  // Pastikan Anda mengimpor model User Anda
use App\Models\Product; // Pastikan Anda mengimpor model Product Anda
use Illuminate\Http\Request;
use Carbon\Carbon; // Digunakan untuk manipulasi tanggal
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan total New Orders (misalnya status 'Pending' atau 'Unpaid')
        $totalNewOrders = Order::where('OrderStatus', 'Waiting Approval') // Sesuaikan status Anda
            ->count();

        // Mendapatkan total Approved Orders (misalnya status 'Approved')
        $totalApprovedOrders = Order::where('OrderStatus', 'Approved') // Sesuaikan status Anda
            ->count();

        // Mendapatkan total User Registrations
        $totalUserRegistrations = User::count();

        // Mendapatkan total Products
        $totalProducts = Product::count();

        // --- Data untuk tabel "Latest New Orders" ---
        $latestNewOrders = Order::orderBy('BookingDate', 'desc')
            ->where('OrderStatus', 'Waiting Approval') // Sesuaikan status
            ->limit(5) // Ambil 5 order terbaru
            ->get();

        // --- Data untuk tabel "Latest User Registrations" ---
        $latestUserRegistrations = User::orderBy('CreatedDate', 'desc') // Asumsi ada kolom CreatedDate
            ->limit(5)
            ->get();

        // --- Data untuk Kalender (Penjualan yang Disetujui dan Dibayar) ---
        // Anda perlu menyesuaikan kolom status pesanan dan status pembayaran di sini
        $approvedPaidOrders = Order::where('OrderStatus', 'Approved')
            ->where('PaymentStatus', 'Paid')
            // Pastikan Anda mengambil 'id' dan 'InvoiceNumber'
            ->get(['id', 'InvoiceNumber', 'BookingDate']);

        $calendarEvents = $approvedPaidOrders->map(function ($order) {
            return [
                'title' => 'Invoice: ' . $order->InvoiceNumber,
                'start' => Carbon::parse($order->BookingDate)->format('Y-m-d'),
                // KIRIMKAN 'id' sebagai parameter untuk route
                'url'   => route('order.customer.invoice', $order->id) // <--- UBAH DI SINI!
            ];
        });

        // --- DATA PENDAPATAN PER BULAN UNTUK GRAFIK ---
        $monthlyRevenue = Order::select(
            DB::raw('MONTH(BookingDate) as month'), // Ekstrak bulan dari BookingDate
            DB::raw('YEAR(BookingDate) as year'),   // Ekstrak tahun
            DB::raw('SUM(TotalPrice) as total_revenue') // Jumlahkan TotalPrice
        )
            ->where('OrderStatus', 'Approved')
            ->where('PaymentStatus', 'Paid')
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Siapkan data untuk Chart.js
        $months = [];
        $revenues = [];
        // Untuk 12 bulan terakhir atau data yang ada
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        // Inisialisasi array pendapatan untuk 12 bulan terakhir dengan 0
        $allMonthsRevenue = array_fill(1, 12, 0); // 1-12 untuk bulan Januari-Desember

        foreach ($monthlyRevenue as $data) {
            // Kita hanya fokus pada tahun saat ini atau beberapa tahun terakhir
            // Jika Anda ingin semua data, logikanya perlu sedikit disesuaikan
            // Untuk kesederhanaan, kita ambil data dari tahun saat ini saja
            if ($data->year == $currentYear) {
                $allMonthsRevenue[$data->month] = (int)$data->total_revenue;
            }
        }

        // Ambil label bulan dan data revenue dari array yang sudah diisi
        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create(null, $m, 1)->monthName; // Nama bulan (Januari, Februari, dst.)
            $revenues[] = $allMonthsRevenue[$m];
        }

        return view('dashboard', compact(
            'totalNewOrders',
            'totalApprovedOrders',
            'totalUserRegistrations',
            'totalProducts',
            'latestNewOrders',
            'latestUserRegistrations',
            'calendarEvents', // Kirim data events ke view
            'months',        // Data bulan untuk label grafik
            'revenues'       // Data pendapatan untuk nilai grafik
        ));
    }
}
