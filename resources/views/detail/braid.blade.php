@extends('layout.master')
@section('content')

    <style>
        /* --- Responsive Preview Image --- */
        .main-preview {
            max-height: 450px;
            width: 100%;
            object-fit: contain;
            border-radius: 8px;
        }

        @media (max-width: 992px) {
            .main-preview {
                max-height: 350px;
            }
        }

        @media (max-width: 576px) {
            .main-preview {
                max-height: 250px;
            }
        }

        /* --- Thumbnail Carousel Layout --- */
        .thumbnail-carousel-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            margin-top: 10px;
            gap: 10px;
        }

        .thumbnail-carousel {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 10px;
            flex-grow: 1;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .thumbnail-carousel::-webkit-scrollbar {
            display: none;
        }

        .product-image-thumb {
            cursor: pointer;
            min-width: 80px;
            height: 80px;
            flex: 0 0 auto;
            overflow: hidden;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .product-image-thumb {
                min-width: 60px;
                height: 60px;
            }
        }

        @media (max-width: 576px) {
            .product-image-thumb {
                min-width: 50px;
                height: 50px;
            }
        }

        /* --- Carousel Buttons --- */
        .carousel-button {
            background-color: rgba(0, 0, 0, 0.4);
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
        }

        @media (max-width: 576px) {
            .carousel-button {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }
        }
    </style>

    <div class="content-wrapper">
        <!-- Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Bridesmaid</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/customer') }}">Home</a></li>
                            <li class="breadcrumb-item active">Bridesmaid</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block d-sm-none">WEDDING Gallery</h3>

                            @if ($galleries->count())
                                <!-- Main Preview -->
                                <div class="col-12 mb-2 preview-container">
                                    @php
                                        $first = $galleries[0];
                                        $ext = pathinfo($first->image_path, PATHINFO_EXTENSION);
                                    @endphp

                                    @if (in_array($ext, ['mp4', 'webm', 'ogg']))
                                        <video id="main-preview" class="product-image main-preview" controls>
                                            <source src="{{ $first->image_path }}" type="video/{{ $ext }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <img id="main-preview" src="{{ $first->image_path }}"
                                            class="product-image main-preview" alt="Gallery Image">
                                    @endif
                                </div>

                                <!-- Thumbnails with Buttons -->
                                <div class="thumbnail-carousel-container">
                                    <button onclick="scrollThumbs(-100)" class="carousel-button">&laquo;</button>
                                    <div class="thumbnail-carousel">
                                        @foreach ($galleries as $index => $gallery)
                                            @php
                                                $ext = pathinfo($gallery->image_path, PATHINFO_EXTENSION);
                                                $isVideo = in_array($ext, ['mp4', 'webm', 'ogg']);
                                            @endphp
                                            <div class="product-image-thumb {{ $index == 0 ? 'active' : '' }}"
                                                data-src="{{ $gallery->image_path }}" data-ext="{{ $ext }}">
                                                @if ($isVideo)
                                                    <div style="position: relative; width: 100%; height: 100%;">
                                                        <video muted
                                                            style="width: 100%; height: 100%; object-fit: cover; pointer-events: none;">
                                                            <source src="{{ $gallery->image_path }}"
                                                                type="video/{{ $ext }}">
                                                        </video>
                                                        <i class="fas fa-play-circle"
                                                            style="position: absolute; color: white; font-size: 20px; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 2;"></i>
                                                    </div>
                                                @else
                                                    <img src="{{ $gallery->image_path }}" alt="Thumb"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                    <button onclick="scrollThumbs(100)" class="carousel-button">&raquo;</button>
                                </div>
                            @else
                                <p>No images or videos in this category.</p>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="col-12 col-sm-6">
                            <h3 class="my-3">Detail Layanan Make Up Bridesmaid</h3>
                            <p class="text-justify">
                                Sebagai pendamping setia di hari istimewa, tampil memukau adalah keharusan bagi setiap
                                *bridesmaid*.
                                MUA.KU menyediakan layanan make up profesional yang dirancang khusus untuk para
                                *bridesmaid*,
                                memastikan Anda tampil serasi dengan tema pernikahan dan memancarkan aura **cantik, fresh,
                                dan menawan**
                                di samping pengantin.
                            </p>

                            <hr>

                            <h4>Pilihan Gaya Riasan Bridesmaid</h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                {{-- Sesuaikan pilihan gaya riasan bridesmaid di sini --}}
                                <label class="btn btn-default text-center active">
                                    <input type="radio" name="bridesmaid_style_option" autocomplete="off" checked>
                                    <strong><i class="fas fa-magic"></i> Soft Glam</strong><br>
                                    <small>Elegan & Natural</small>
                                </label>
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="bridesmaid_style_option" autocomplete="off">
                                    <strong><i class="fas fa-sun"></i> Fresh & Radiant</strong><br>
                                    <small>Cerah & Berseri</small>
                                </label>
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="bridesmaid_style_option" autocomplete="off">
                                    <strong><i class="fas fa-gem"></i> Classic Beauty</strong><br>
                                    <small>Anggun Sepanjang Masa</small>
                                </label>
                                {{-- Tambahkan lebih banyak gaya jika diperlukan --}}
                            </div>

                            <h4 class="mt-3">Detail Paket Layanan <small>Pilih yang sesuai</small></h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                {{-- Contoh paket layanan untuk bridesmaid --}}
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="package_option" autocomplete="off">
                                    <strong><i class="fas fa-user"></i> Paket Single</strong><br>
                                    <small>Rias 1 Bridesmaid</small>
                                </label>
                                <label class="btn btn-default text-center active">
                                    <input type="radio" name="package_option" autocomplete="off" checked>
                                    <strong><i class="fas fa-user-friends"></i> Paket Duo</strong><br>
                                    <small>Rias 2 Bridesmaid</small>
                                </label>
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="package_option" autocomplete="off">
                                    <strong><i class="fas fa-users"></i> Paket Group</strong><br>
                                    <small>Rias 3+ Bridesmaid</small>
                                </label>
                            </div>

                            <div class="bg-gray py-2 px-3 mt-4">
                                <h2 class="mb-0">Mulai dari Rp 350.000,- / orang</h2> {{-- Contoh harga untuk bridesmaid --}}
                                <h4 class="mt-0"><small>Harga dapat disesuaikan dengan detail paket dan jumlah
                                        orang.</small>
                                </h4>
                            </div>

                            <div class="mt-4">
                                {{-- Tombol "Pesan Layanan Ini" dialihkan ke halaman /customer dan section #products --}}
                                <a href="{{ url('/customer#products') }}" class="btn btn-primary btn-lg btn-flat">
                                    <i class="fas fa-calendar-check fa-lg mr-2"></i> Pesan Layanan Ini
                                </a>

                                {{-- Tombol "Tanya Lebih Lanjut" dialihkan ke WhatsApp --}}
                                {{-- Pastikan nomor WA ini adalah nomor MUA.KU yang benar --}}
                                <a href="https://wa.me/6281212345678?text=Halo%20MUA.KU,%20saya%20tertarik%20dengan%20layanan%20make%20up%20bridesmaid%20Anda.%20Bisakah%20saya%20bertanya%20lebih%20lanjut?"
                                    class="btn btn-default btn-lg btn-flat" target="_blank">
                                    <i class="fab fa-whatsapp fa-lg mr-2"></i> Tanya Lebih Lanjut
                                </a>
                            </div>

                            <div class="mt-4 product-share">
                                <p class="mb-2">Bagikan Layanan Ini:</p>
                                @php
                                    // Mendapatkan URL halaman saat ini
                                    $currentPageUrl = url()->current();
                                    // Meng-encode URL agar aman untuk parameter query di link sharing
                                    $encodedPageUrl = urlencode($currentPageUrl);
                                    // Teks ajakan untuk dibagikan (disesuaikan untuk bridesmaid)
                                    $shareTextBridesmaid = urlencode(
                                        'Ajak sahabatmu tampil memukau sebagai bridesmaid bareng MUA.KU!',
                                    );
                                    $shareTextLongBridesmaid = urlencode(
                                        'MUA.KU hadir untuk menyempurnakan penampilan bridesmaid di hari spesial. Yuk, cek detail layanannya di sini:',
                                    );
                                @endphp

                                {{-- Tombol X (Twitter) Share --}}
                                <a href="https://twitter.com/intent/tweet?url={{ $encodedPageUrl }}&text={{ $shareTextBridesmaid }}"
                                    class="text-gray" target="_blank" title="Bagikan ke X (Twitter)">
                                    <i class="fab fa-twitter-square fa-2x mr-2"></i>
                                </a>

                                {{-- Tombol Instagram (link ke profil) --}}
                                {{-- Ganti 'yovanda.makeup' dengan username Instagram MUA.KU yang sebenarnya --}}
                                <a href="https://www.instagram.com/yovanda.makeup" class="text-gray" target="_blank"
                                    title="Kunjungi Instagram MUA.KU">
                                    <i class="fab fa-instagram-square fa-2x mr-2"></i>
                                </a>

                                {{-- Tombol WhatsApp Share --}}
                                {{-- Pastikan nomor WA untuk share ini jika berbeda dengan tombol "Tanya Lebih Lanjut" --}}
                                <a href="https://wa.me/6289673906621/?text={{ $shareTextLongBridesmaid }}%20{{ $encodedPageUrl }}"
                                    class="text-gray" target="_blank" title="Bagikan via WhatsApp">
                                    <i class="fab fa-whatsapp-square fa-2x mr-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- <!-- Tabs -->
                        <div class="row mt-4">
                            <nav class="w-100">
                                <div class="nav nav-tabs" id="product-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab"
                                        href="#product-desc" role="tab" aria-controls="product-desc"
                                        aria-selected="true">Description</a>
                                    <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab"
                                        href="#product-comments" role="tab" aria-controls="product-comments"
                                        aria-selected="false">Comments</a>
                                    <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab"
                                        href="#product-rating" role="tab" aria-controls="product-rating"
                                        aria-selected="false">Rating</a>
                                </div>
                            </nav>
                        </div> --}}

                </div>
            </div>
    </div>
    </section>
    </div>

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function scrollThumbs(amount) {
            const container = document.querySelector('.thumbnail-carousel');
            container.scrollBy({
                left: amount,
                behavior: 'smooth'
            });
        }

        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                const $this = $(this);
                const src = $this.data('src');
                const ext = $this.data('ext');
                let newContent = '';
                console.log("Thumbnail clicked"); // Tambahkan ini untuk debug
                if (['mp4', 'webm', 'ogg'].includes(ext)) {
                    newContent = `
                    <video id="main-preview" class="product-image main-preview" controls>
                        <source src="${src}" type="video/${ext}">
                        Your browser does not support the video tag.
                    </video>
                `;
                } else {
                    newContent = `
                    <img id="main-preview" src="${src}" class="product-image main-preview" alt="Gallery Image">
                `;
                }

                $('.preview-container').html(newContent);
                $('.product-image-thumb.active').removeClass('active');
                $this.addClass('active');
            });
        });
    </script>
@endsection
@endsection
