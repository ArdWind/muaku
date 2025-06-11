<?php

use App\Http\Controllers\ApproveOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\DataUserController;
use App\Http\Controllers\FrontEnd\ProductController as FrontEndProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TestMinioController;
use App\Http\Controllers\GalleryController;
use App\Models\Product;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Public Routes ---
// Halaman Utama (Homepage)
Route::get('/', function () {
    // Ambil data produk dan kirim ke view
    $data = Product::select('product_name', 'description', 'product_img', 'price', 'discount')->get();
    return view('frontEnd.product.index', compact('data'));
})->name('home');

// Autentikasi
Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Google OAuth
Route::get('/auth-google-redirect', [AuthController::class, 'googleRedirect']);
Route::get('/auth-google-callback', [AuthController::class, 'googleCallback']);

// Minio Test Routes
Route::get('/minio', [TestMinioController::class, 'index'])->name('minio.index');
Route::post('/minio', [TestMinioController::class, 'store'])->name('minio.store');

// Detail Produk
Route::prefix('detail')->name('detail.')->group(function () {
    Route::get('/wedding', [GalleryController::class, 'weddingDetail'])->name('wedding');
    Route::get('/graduation', [GalleryController::class, 'graduationDetail'])->name('grad');
    Route::get('/brides', [GalleryController::class, 'bridesDetail'])->name('braid');
    Route::get('/engagement', [GalleryController::class, 'engDetail'])->name('eng');
});

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// ------------------------------------------------------------------------------------------------------------------------------

// --- Authenticated & Role-Based Routes ---

// Untuk Customer (membutuhkan autentikasi dan role 'customer')
Route::middleware(['auth', 'check_role:customer'])->group(function () {
    // Verifikasi
    Route::prefix('verify')->group(function () {
        Route::get('/', [VerificationController::class, 'index']);
        Route::post('/', [VerificationController::class, 'store']);
        Route::get('/{unique_id}', [VerificationController::class, 'show']);
        Route::put('/{unique_id}', [VerificationController::class, 'update']);
    });

    // Halaman Utama Customer (membutuhkan verifikasi status)
    Route::middleware(['check_status'])->group(function () {
        Route::get('/customer', [FrontEndProductController::class, 'index'])->name('product.index');
    });
});

// Untuk Admin & Staff (membutuhkan autentikasi dan role 'admin' atau 'staff')
Route::middleware(['auth', 'check_role:admin,staff'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Data Users
    Route::get('/data-users', [DataUserController::class, 'DataUserView'])->name('data_users.index');
    Route::post('/data-users', [DataUserController::class, 'store'])->name('data_users.store');
    Route::get('/data-users/create', [DataUserController::class, 'create'])->name('data_users.create');
    Route::get('/data-users/{user}/edit', [DataUserController::class, 'edit'])->name('data_users.edit');
    Route::put('/data-users/{user}', [DataUserController::class, 'update'])->name('data_users.update');
    Route::delete('/data-users/{user}', [DataUserController::class, 'destroy'])->name('data_users.destroy');

    // Manajemen Data Products
    Route::get('/data-products', [ProductController::class, 'DataProductView'])->name('data_products.index');
    Route::post('/data-products', [ProductController::class, 'store'])->name('data_products.store');
    Route::get('/data-products/create', [ProductController::class, 'create'])->name('data_products.create');
    Route::get('/data-products/{product}/edit', [ProductController::class, 'edit'])->name('data_products.edit');
    Route::put('/data-products/{product}', [ProductController::class, 'update'])->name('data_products.update');
    Route::delete('/data-products/{product}', [ProductController::class, 'destroy'])->name('data_products.destroy');

    // Manajemen Data Galleries
    Route::resource('data-galeries', GalleryController::class)
        ->except(['show'])
        ->names([
            'index'   => 'data_galeries.index',
            'create'  => 'data_galeries.create',
            'store'   => 'data_galeries.store',
            'edit'    => 'data_galeries.edit',
            'update'  => 'data_galeries.update',
            'destroy' => 'data_galeries.destroy',
        ]);
});

// Untuk Admin Saja (membutuhkan autentikasi dan role 'admin')
Route::middleware(['auth', 'check_role:admin'])->group(function () {
    // Rute spesifik admin di sini jika ada.
});

// Rute untuk menampilkan form order dengan ID produk
Route::get('/order/create/{product}', [OrderController::class, 'create'])->name('order.create');

// Rute untuk memproses pengiriman form order
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Contoh rute untuk halaman sukses setelah pembayaran (akan diarahkan setelah Midtrans)
// Route::get('/order/{order}/pay', [OrderController::class, 'customerPay'])->name('order.customer.pay');

// Rute untuk menampilkan form pemesanan produk tertentu
// Route::get('/order/create/{product}', [OrderController::class, 'create'])->name('order.create');

// Rute untuk menyimpan data pemesanan
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Rute untuk menampilkan daftar semua order milik pengguna yang sedang login (sekarang ini adalah halaman "Booking" Anda)
Route::get('/orders/my-list', [OrderController::class, 'customerPay'])->name('order.customer.pay');

// Rute BARU untuk menampilkan detail order (invoice) untuk diedit/print
// Menggunakan Route Model Binding untuk Order
Route::get('/orders/{order}/invoice', [OrderController::class, 'showInvoice'])->name('order.customer.invoice');

// Rute BARU untuk menyimpan perubahan dari halaman edit
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('order.customer.update');


// Rute untuk menampilkan halaman invoice dalam format HTML (jika Anda masih memerlukannya secara terpisah)
// Saya menggunakan nama rute yang jelas agar tidak ambigu.
Route::get('/invoices/{order}/html', [OrderController::class, 'showInvoiceHtml'])->name('invoice.html');

// Rute untuk menampilkan preview PDF di browser
// Pengguna bisa cetak/simpan dari sini
Route::get('/invoices/{order}/pdf/preview', [OrderController::class, 'previewPdf'])->name('invoice.pdf.preview');

// Rute untuk langsung mengunduh PDF
// Pengguna bisa memilih untuk mendownload langsung tanpa preview
Route::get('/invoices/{order}/pdf/download', [OrderController::class, 'downloadPdf'])->name('invoice.pdf.download');


// Inisiasi Pembayaran Midtrans
Route::get('/order/{order}/pay-now', [OrderController::class, 'initiatePayment'])->name('order.initiate_payment');

// --- Rute BARU untuk Staff ---
// Rute untuk menampilkan semua order untuk Staff
// Asumsi: Rute ini akan dilindungi oleh middleware 'auth' dan 'role:staff' atau semacamnya nanti
Route::get('/staff/orders', [ApproveOrderController::class, 'index'])->name('order.staff.index');
Route::post('/staff/orders/{order}/update-status', [ApproveOrderController::class, 'updateOrderStatus'])->name('order.staff.update_status');
