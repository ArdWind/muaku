<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

// Midtrans classes - uncommented for active integration
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification; // Diperlukan untuk menangani notifikasi Midtrans

class OrderController extends Controller
{
    /**
     * Displays the order creation form with pre-filled user data if logged in.
     */
    public function create(Product $product): View
    {
        $customerName = null;
        $phoneNumber = null;
        $customerAddress = null;

        if (Auth::check()) {
            $user = Auth::user();
            $customerName = $user->name;
            $phoneNumber = $user->Phone;
            $customerAddress = $user->address;
        }

        return view('order.create', compact('product', 'customerName', 'phoneNumber', 'customerAddress'));
    }

    /**
     * Processes order form data, saves the order to the database,
     * and generates a unique invoice number before redirecting.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'CustomerName' => 'required|string|max:255',
            'Address'      => 'required|string',
            'Phone'        => 'nullable|string|max:32',
            'Quantity'     => 'required|integer|min:1',
            'TotalPrice'   => 'required|numeric|min:0', // This is client-side total, backend will recalculate
            'BookingDate'  => 'required|date|after_or_equal:today',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to place an order.');
        }

        $product = Product::findOrFail($request->product_id);

        // Recalculate TotalPrice on the backend for security and accuracy
        $calculatedPricePerItem = $product->price;
        if (intval($product->discount) > 0) {
            $initialPrice = intval($product->price);
            $discountPercentage = intval($product->discount);
            $discountAmount = ($discountPercentage / 100) * $initialPrice;
            $calculatedPricePerItem = $initialPrice - $discountAmount;
        }
        $finalTotalPrice = $calculatedPricePerItem * $request->Quantity;

        if ($finalTotalPrice != $request->TotalPrice) {
            Log::warning('Total price mismatch detected and corrected for Order ID: ' . $product->id . ' by user: ' . $user->id, [
                'client_total' => $request->TotalPrice,
                'server_calculated_total' => $finalTotalPrice
            ]);
            $request->merge(['TotalPrice' => $finalTotalPrice]); // Correct client-side total
        }

        $order = new Order();
        $order->CustomerName = $user->name;
        $order->Address = $request->Address;
        $order->Phone = $request->Phone;
        $order->Product = $product->product_name;
        $order->Quantity = $request->Quantity;
        $order->TotalPrice = $finalTotalPrice;
        $order->OrderStatus = 'Waiting Approval'; // Default status
        $order->PaymentStatus = 'Unpaid';       // Default status
        $order->BookingDate = $request->BookingDate;

        // Audit trail fields
        $order->CreatedBy = $user->name;
        $order->CreatedDate = Carbon::now();
        $order->CompanyCode = '1';
        $order->IsDeleted = 0;
        // user_id is recommended for database relations, uncomment if used in migration:
        // $order->user_id = Auth::id();

        // --- UNIQUE INVOICE NUMBER GENERATION LOGIC ---
        $currentDate = Carbon::now();
        $year = $currentDate->format('Y');
        $month = $currentDate->format('m');

        $lastOrder = Order::whereYear('CreatedDate', $year)
            ->whereMonth('CreatedDate', $month)
            ->whereNotNull('InvoiceNumber')
            ->orderBy('CreatedDate', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $sequenceNumber = 1;
        if ($lastOrder && $lastOrder->InvoiceNumber) {
            $parts = explode('/', $lastOrder->InvoiceNumber);
            if (count($parts) === 5) {
                $lastSequence = (int) $parts[4];
                $sequenceNumber = $lastSequence + 1;
            }
        }

        $invoiceNumber = sprintf("INV/%s/%s/MUA.KU/%03d", $year, $month, $sequenceNumber);
        $order->InvoiceNumber = $invoiceNumber;
        // --- END UNIQUE INVOICE NUMBER GENERATION LOGIC ---

        $order->save();

        return redirect()->route('order.customer.pay')->with('success', 'Your order has been placed! Awaiting staff approval.');
    }

    /**
     * Displays a list of all orders belonging to the currently logged-in user (Customer's "My Orders" page).
     */
    public function customerPay(): View|RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your orders.');
        }

        // Retrieve orders where CustomerName matches the active user's name
        $orders = Order::where('CustomerName', Auth::user()->name)
            ->orderBy('CreatedDate', 'desc')
            ->get();

        return view('order.customer.pay', compact('orders'));
    }

    /**
     * Displays the order details as an invoice. Accessible by customer (their own order) or staff.
     */
    public function showInvoice(Order $order): View|RedirectResponse
    {
        // Allow access if:
        // 1. Logged-in user is the customer who owns the order ($order->CustomerName)
        // OR
        // 2. Logged-in user has a 'staff' role (adjust `Auth::user()->is_staff ?? false` to your actual role logic, e.g., `Auth::user()->is_admin` or `Auth::user()->hasRole('staff')`)
        // if (!Auth::check() || (Auth::user()->name !== $order->CustomerName && !(Auth::user()->is_staff ?? false))) { // Placeholder for staff role check
        //     abort(403, 'You are not authorized to access this order.');
        // }

        return view('order.customer.invoice', compact('order'));
    }

    /**
     * Initiates the Midtrans payment process for a specific order.
     * Only accessible by the relevant customer when order is Approved and Unpaid.
     */
    public function initiatePayment(Order $order): RedirectResponse
    {
        if (!Auth::check() || Auth::user()->name !== $order->CustomerName) {
            abort(403, 'You are not authorized to initiate payment for this order.');
        }

        if ($order->OrderStatus !== 'Approved' || $order->PaymentStatus !== 'Unpaid') {
            return redirect()->back()->with('error', 'Payment can only be made for approved and unpaid orders.');
        }

        // --- Midtrans Configuration and Parameter Building ---
        // PENTING: Menggunakan config('midtrans.server_key') sesuai request Anda
        Config::$serverKey = config('midtrans.server_key');
        // PENTING: Menggunakan config('midtrans.is_production') sesuai request Anda
        Config::$isProduction = config('midtrans.is_production'); // true for production, false for sandbox
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // pricePerUnit tetap dikomentari karena versi ini mengirim TotalPrice sebagai satu item
        // $pricePerUnit = $order->Quantity > 0 ? ($order->TotalPrice / $order->Quantity) : $order->TotalPrice;

        $params = [
            'transaction_details' => [
                'order_id'      => $order->id, // Menggunakan ID Order dari database sebagai Order ID di Midtrans
                'gross_amount'  => $order->TotalPrice,    // Total harga keseluruhan order
            ],
            'customer_details' => [
                'first_name'    => $order->CustomerName,
                'email'         => Auth::user()->email ?? 'customer@example.com', // Menggunakan email user login
                'phone'         => $order->Phone,       // Menggunakan phone dari order
                'address'       => $order->Address,      // Menggunakan address dari order
            ],
            'item_details' => [[
                'id'            => $order->id,            // Menggunakan ID Order sebagai ID item
                'price'         => $order->TotalPrice,    // Harga item ini adalah TotalPrice seluruh order
                'quantity'      => 1,                     // Kuantitas di-hardcode 1 karena mewakili seluruh order
                'name'          => 'Order ' . $order->Product,      // Nama produk
            ]],
            // TAMBAHKAN CALLBACK UNTUK REDIRECTION SETELAH PEMBAYARAN
            'callbacks' => [
                'finish' => route('order.customer.pay'), // Redirect ke halaman daftar order setelah pembayaran selesai
                'unfinish' => route('order.customer.pay'), // Redirect ke halaman daftar order jika pembayaran tidak selesai
                'error' => route('order.customer.pay'), // Redirect ke halaman daftar order jika ada error
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            // Optionally, save the snapToken to the order record for future reference
            return redirect("https://app.sandbox.midtrans.com/snap/v2/vtweb/{$snapToken}"); // IMPORTANT: Change domain for production
        } catch (\Exception $e) {
            // Log error lebih detail untuk debugging
            Log::error('Midtrans Error during initiation: ' . $e->getMessage(), [
                'order_id' => $order->id,
                'midtrans_params' => $params, // Log parameter yang dikirim ke Midtrans
                'exception_trace' => $e->getTraceAsString() // Log stack trace
            ]);
            return redirect()->back()->with('error', 'Failed to initiate payment. Please try again. Check Laravel logs for details.');
        }
    }

    /**
     * Generates a PDF invoice for a specific order. Accessible by customer (their own order) or staff.
     */
    public function showInvoiceHtml(Order $order)
    {
        return view('order.customer.invoice_pdf', compact('order'));
    }

    /**
     * Menampilkan preview PDF invoice di browser.
     * Nama file dijamin aman menggunakan Str::slug().
     * Catatan: Tidak ada cek autentikasi, jadi siapa pun bisa mengakses jika tahu URL.
     */
    public function previewPdf(Order $order)
    {
        // Pastikan nama file bersih dari karakter path (seperti / atau \)
        // Str::slug akan mengubah string menjadi format yang aman untuk URL/nama file
        $filename = 'invoice_' . Str::slug($order->InvoiceNumber) . '.pdf';

        $pdf = Pdf::loadView('order.customer.invoice_pdf', compact('order'));

        // Mengembalikan PDF untuk ditampilkan di browser
        return $pdf->stream($filename);
    }

    /**
     * Mengunduh PDF invoice langsung.
     * Nama file dijamin aman menggunakan Str::slug().
     * Catatan: Tidak ada cek autentikasi, jadi siapa pun bisa mengakses jika tahu URL.
     */
    public function downloadPdf(Order $order)
    {
        // Pastikan nama file bersih dari karakter path (seperti / atau \)
        // Str::slug akan mengubah string menjadi format yang aman untuk URL/nama file
        $filename = 'invoice_' . Str::slug($order->InvoiceNumber) . '.pdf';

        $pdf = Pdf::loadView('order.customer.invoice_pdf', compact('order'));

        // Mengembalikan PDF untuk diunduh
        return $pdf->download($filename);
    }

    /**
     * Handles payment notifications (callbacks) from Midtrans.
     * This is the endpoint Midtrans will call after a payment event.
     * This route MUST be publicly accessible (no 'auth' or 'csrf' middleware).
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function handleMidtransNotification(Request $request)
    {
        // Configure Midtrans (must match initiatePayment configuration)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            Log::error('Midtrans Notification: Error creating Notification object: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to process notification.'], 500);
        }

        $transactionStatus = $notif->transaction_status;
        $fraudStatus = $notif->fraud_status;
        $orderId = $notif->order_id;
        $statusCode = $notif->status_code; // Ambil status_code
        $grossAmount = $notif->gross_amount; // Ambil gross_amount

        // **PENTING: Verifikasi signature_key**
        $input = $orderId . $statusCode . $grossAmount . config('midtrans.server_key');
        $hashed = hash('sha512', $input);

        if ($hashed != $notif->signature_key) {
            Log::warning('Midtrans Notification: Invalid signature key for Order ID: ' . $orderId);
            return response()->json(['message' => 'Invalid signature key'], 403); // Forbidden
        }

        $order = Order::where('id', $orderId)->first();

        if (!$order) {
            Log::error('Midtrans Notification: Order not found for ID: ' . $orderId);
            return response()->json(['message' => 'Order not found'], 404);
        }

        Log::info('Midtrans Notification received for Order ID: ' . $order->id, [
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'order_id' => $orderId,
            'current_order_status' => $order->OrderStatus,
            'current_payment_status' => $order->PaymentStatus,
        ]);

        // ... (Logika update status order Anda tetap sama di sini) ...

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $order->PaymentStatus = 'Failed';
                $order->OrderStatus = 'Rejected';
                Log::info('Midtrans Notification: Order ' . $order->id . ' status set to Challenge/Failed.');
            } else if ($fraudStatus == 'accept') {
                $order->PaymentStatus = 'Paid';
                if ($order->OrderStatus == 'Waiting Approval') {
                    $order->OrderStatus = 'Approved';
                }
                Log::info('Midtrans Notification: Order ' . $order->id . ' status set to Paid (Capture-Accept).');
            }
        } else if ($transactionStatus == 'settlement') {
            $order->PaymentStatus = 'Paid';
            if ($order->OrderStatus == 'Waiting Approval') {
                $order->OrderStatus = 'Approved';
            }
            Log::info('Midtrans Notification: Order ' . $order->id . ' status set to Paid (Settlement).');
        } else if ($transactionStatus == 'pending') {
            $order->PaymentStatus = 'Unpaid';
            Log::info('Midtrans Notification: Order ' . $order->id . ' status set to Pending.');
        } else if ($transactionStatus == 'deny') {
            $order->PaymentStatus = 'Failed';
            $order->OrderStatus = 'Rejected';
            Log::warning('Midtrans Notification: Order ' . $order->id . ' status set to Denied (Failed).');
        } else if ($transactionStatus == 'expire') {
            $order->PaymentStatus = 'Failed';
            $order->OrderStatus = 'Rejected';
            Log::warning('Midtrans Notification: Order ' . $order->id . ' status set to Expired (Failed).');
        } else if ($transactionStatus == 'cancel') {
            $order->PaymentStatus = 'Failed';
            $order->OrderStatus = 'Rejected';
            Log::warning('Midtrans Notification: Order ' . $order->id . ' status set to Cancelled (Failed).');
        } else if ($transactionStatus == 'refund' || $transactionStatus == 'partial_refund') {
            $order->PaymentStatus = 'Failed';
            $order->OrderStatus = 'Rejected';
            Log::info('Midtrans Notification: Order ' . $order->id . ' status set to Refunded (Failed).');
        }

        $order->LastUpdatedBy = 'Midtrans Notif';
        $order->LastUpdatedDate = Carbon::now();
        $order->save();

        return response()->json(['message' => 'Notification handled successfully'], 200);
    }

    // public function handleMidtransNotification(Request $request)
    // {
    //     $serverKey = config('midtrans.server_key');
    //     $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
    //     if($hashed == $request->signature_key){
    //         if($request->transaction_status == 'capture'){
    //             $order = Order::find($request->order_id);
    //             $order->update(['PaymentStatus'=> 'Paid']);
    //         }
    //     }
    // }
}
