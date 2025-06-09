<?php

namespace App\Http\Controllers;

use App\Models\Order; // Import model Order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Digunakan jika Anda ingin membatasi akses berdasarkan peran
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon; // Digunakan untuk CreatedDate/LastUpdatedDate jika diperlukan

class ApproveOrderController extends Controller
{
    /**
     * Menampilkan daftar semua order untuk staff/admin.
     * Tidak disortir per user.
     */
    public function index(): View|RedirectResponse // Perbolehkan View atau RedirectResponse
    {
        // Anda bisa menambahkan middleware di constructor controller ini
        // atau di definisi rute untuk membatasi akses hanya untuk staff/admin.
        // Contoh (jika ada peran 'staff' di model User):
        // if (!Auth::check() || !Auth::user()->hasRole('staff')) {
        //     abort(403, 'Unauthorized access.');
        // }

        // Mengambil semua order tanpa filter CustomerName
        $orders = Order::orderBy('CreatedDate', 'desc')->get();

        return view('order.staff.order', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        // Pastikan user sudah login untuk memperbarui status pesanan.
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to update order status.');
        }

        // Anda bisa menambahkan logika peran staff di sini jika diperlukan.
        // Contoh: Jika Anda memiliki peran 'staff' di model User
        // if (!Auth::user()->hasRole('staff')) {
        //     abort(403, 'You are not authorized to perform this action.');
        // }

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);

        $newStatus = $request->input('status');

        // Hanya perbarui jika status saat ini masih 'Waiting Approval'
        if ($order->OrderStatus === 'Waiting Approval') {
            $order->OrderStatus = $newStatus;
            $order->LastUpdatedBy = Auth::user()->name; // Catat siapa yang memperbarui
            $order->LastUpdatedDate = Carbon::now(); // Catat waktu pembaruan
            $order->save();

            $message = "Order #{$order->id} has been {$newStatus}.";
            // Redirect ke halaman daftar order staff setelah update
            return redirect()->route('order.staff.index')->with('success', $message); // <<< PERUBAHAN DI SINI
        } else {
            return redirect()->route('order.staff.index')->with('error', "Order #{$order->id} status has already been updated."); // <<< PERUBAHAN DI SINI
        }
    }
}
