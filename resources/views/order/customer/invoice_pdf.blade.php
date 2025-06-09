<!DOCTYPE html>
<html>

<head>
    <title>Invoice Pesanan #{{ $order->InvoiceNumber }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            /* Penting: Atur posisi body relatif untuk konteks positioning */
            position: relative;
        }

        /* Kontainer untuk gambar latar belakang */
        .background-image-container {
            position: fixed;
            /* Membuat elemen tetap pada posisinya di halaman */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            /* Memastikan div ini berada di belakang konten lain */
            overflow: hidden;
            /* Mencegah gambar keluar dari batas container */
            display: flex;
            align-items: center;
            /* Memusatkan gambar secara vertikal */
            justify-content: center;
            /* Memusatkan gambar secara horizontal */
        }

        .background-image-container img {
            width: 100%;
            /* Sesuaikan ukuran gambar latar belakang menjadi 100% dari lebar halaman */
            height: auto;
            /* Mempertahankan aspek rasio */
            opacity: 0.05;
            /* Tingkat transparansi untuk gambar saja */
            object-fit: contain;
            /* Memastikan gambar tidak terdistorsi dan sepenuhnya terlihat */
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            /* Mengubah ketebalan border menjadi 2px */
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 18px;
        }

        .header h3 {
            margin: 5px 0 0;
            padding: 0;
            color: #555;
            font-size: 14px;
        }

        .header p {
            margin: 2px 0;
            color: #777;
            font-size: 10px;
        }

        .invoice-info-section,
        .address-section,
        .item-details-section {
            margin-bottom: 15px;
            border-collapse: collapse;
            width: 100%;
        }

        .invoice-info-section td,
        .address-section td,
        .item-details-section th,
        .item-details-section td {
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        .invoice-info-section strong,
        .address-section strong {
            display: block;
            margin-bottom: 3px;
            font-size: 11px;
        }

        .invoice-info-section .value {
            font-size: 11px;
        }

        .item-details-section {
            border: 1px solid #ddd;
        }

        .item-details-section th {
            /* Mengubah background-color menjadi rgba untuk transparansi */
            background-color: rgba(247, 247, 247, 0.6);
            /* 0.7 = 70% opacity */
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #eee;
        }

        .item-details-section td {
            border-bottom: 1px solid #eee;
            border-right: 1px solid #eee;
        }

        .item-details-section tr:last-child td {
            border-bottom: none;
        }

        .item-details-section th:last-child,
        .item-details-section td:last-child {
            border-right: none;
        }

        .total-section {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .total-section tr td {
            padding: 6px 8px;
            text-align: right;
            border-bottom: 1px solid #eee;
        }

        .total-section tr:last-child td {
            border-bottom: none;
            font-weight: bold;
            font-size: 12px;
            /* Mengubah background-color menjadi rgba untuk transparansi */
            background-color: rgba(247, 247, 247, 0.6);
            /* 0.7 = 70% opacity */
        }

        .total-section .label {
            width: 70%;
        }

        .notes-section {
            margin-top: 30px;
            padding: 15px;
            /* Mengubah background-color menjadi rgba untuk transparansi */
            background-color: rgba(249, 249, 249, 0.6);
            /* 0.8 = 80% opacity */
            border: 1px solid #e7e7e7;
            border-radius: 5px;
            font-size: 10px;
            color: #555;
        }

        .notes-section h4 {
            margin-top: 0;
            color: #333;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .notes-section ul {
            list-style-type: disc;
            margin: 0 0 10px 15px;
            padding: 0;
        }

        .notes-section li {
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            color: #777;
            font-size: 10px;
        }
    </style>
</head>

<body>
    {{-- Ini adalah kontainer untuk gambar latar belakang --}}
    <div class="background-image-container">
        <img src="{{ public_path('asset/cust/wmmuaku.png') }}" alt="Background Logo MUA.KU" style="border-radius: 8px;">
    </div>

    <div class="container">
        <div class="header">
            {{-- Menggunakan logo utama dengan public_path() agar DomPDF bisa mengaksesnya --}}
            <img src="{{ public_path('asset/cust/ico1.png') }}" alt="Logo MUA.KU"
                style="height: 50px; margin-bottom: 10px; border-radius: 8px;">
            <h2>INVOICE PESANAN</h2>
            <h3>MUA.KU</h3>
            <p>Perumahan Mangunjaya Lestari 2 KB 26 No 11, Kecamatan Tambun Selatan, Kabupaten Bekasi</p>
            <p>Telp: +62 896-7390-6621 | Email: youvandamaysha@gmail.com</p>
        </div>

        <table class="invoice-info-section">
            <tr>
                <td style="width: 50%;">
                    <strong>Nomor Invoice:</strong> <span class="value">{{ $order->InvoiceNumber }}</span><br>
                    <strong>Order ID:</strong> <span class="value">{{ $order->id }}</span><br>
                    <strong>Status Pembayaran:</strong> <span class="value">{{ $order->PaymentStatus }}</span><br>
                </td>
                <td style="width: 50%;">
                    <strong>Tanggal Invoice:</strong> <span
                        class="value">{{ \Carbon\Carbon::parse($order->CreatedDate)->format('d F Y') }}</span><br>
                    <strong>Tanggal Booking:</strong> <span
                        class="value">{{ \Carbon\Carbon::parse($order->BookingDate)->format('d F Y') }}</span><br>
                    <strong>Status Order:</strong> <span class="value">{{ $order->OrderStatus }}</span><br>
                </td>
            </tr>
        </table>

        <table class="address-section">
            <tr>
                <td style="width: 50%;">
                    <strong>Ditagih Kepada:</strong><br>
                    {{ $order->CustomerName }}<br>
                    {{ $order->Address }}<br>
                    Telp: {{ $order->Phone }}
                </td>
            </tr>
        </table>

        <table class="item-details-section">
            <thead>
                <tr>
                    <th style="width: 50%;">Produk</th>
                    <th style="width: 15%;">Kuantitas</th>
                    <th style="width: 20%;">Harga Satuan</th>
                    <th style="width: 15%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->Product }}</td>
                    <td>{{ $order->Quantity }}</td>
                    <td>Rp {{ number_format($order->TotalPrice / $order->Quantity, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="total-section">
            <tr>
                <td class="label">SUBTOTAL:</td>
                <td>Rp {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">TOTAL:</td>
                <td>Rp {{ number_format($order->TotalPrice, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="notes-section">
            <h4>Catatan Penting:</h4>
            <ul>
                <li>Terima kasih atas kepercayaan Anda memilih layanan <strong>MUA.KU</strong> untuk momen spesial Anda.
                </li>
                <li>Mohon lakukan pembayaran sesuai dengan total invoice. Pastikan bukti transfer disimpan.</li>
                <li>Untuk <strong>perubahan jadwal</strong> atau informasi lainnya, harap hubungi kami maksimal
                    <strong>7 hari</strong> sebelum
                    hari H.
                </li>
                <li><strong>Pembatalan pesanan</strong> kurang dari <strong>3 hari</strong> sebelum hari H akan
                    dikenakan biaya <strong>50%</strong> dari total
                    biaya.</li>
                <li>Harga dapat disesuaikan jika ada permintaan <strong>tambahan layanan</strong> di luar paket yang
                    disepakati, atau
                    perubahan lokasi yang signifikan.</li>
                <li>Pastikan area kerja (lokasi makeup) memiliki <strong>pencahayaan yang baik</strong> dan
                    <strong>ruang yang cukup</strong>
                    untuk kenyamanan tim MUA.
                </li>
                <li>Kami berkomitmen untuk memberikan hasil terbaik. Komunikasi yang baik adalah kunci!</li>
            </ul>
        </div>

        <div class="footer">
            <p>Terima kasih atas pesanan Anda! Kami berharap dapat menjadi bagian yang tak terlupakan dalam hari bahagia
                Anda.</p>
            <p>&copy; {{ date('Y') }} MUA.KU. Semua hak dilindungi.</p>
        </div>
    </div>
</body>

</html>
