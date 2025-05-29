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
                        <h1>E-commerce</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">E-commerce</li>
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
                            <h3 class="my-3">LOWA Men’s Renegade GTX Mid Hiking Boots</h3>
                            <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu
                                stumptown aliqua butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh
                                mi, qui irure terr.</p>

                            <hr>
                            <!-- Colors -->
                            <h4>Available Colors</h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach (['green', 'blue', 'purple', 'red', 'orange'] as $i => $color)
                                    <label class="btn btn-default text-center {{ $i == 0 ? 'active' : '' }}">
                                        <input type="radio" name="color_option" autocomplete="off"
                                            {{ $i == 0 ? 'checked' : '' }}>
                                        {{ ucfirst($color) }}<br>
                                        <i class="fas fa-circle fa-2x text-{{ $color }}"></i>
                                    </label>
                                @endforeach
                            </div>

                            <!-- Size -->
                            <h4 class="mt-3">Size <small>Please select one</small></h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach (['S' => 'Small', 'M' => 'Medium', 'L' => 'Large', 'XL' => 'Xtra-Large'] as $code => $label)
                                    <label class="btn btn-default text-center">
                                        <input type="radio" name="size_option" autocomplete="off">
                                        <span class="text-xl">{{ $code }}</span><br>{{ $label }}
                                    </label>
                                @endforeach
                            </div>

                            <!-- Price -->
                            <div class="bg-gray py-2 px-3 mt-4">
                                <h2 class="mb-0">$80.00</h2>
                                <h4 class="mt-0"><small>Ex Tax: $80.00</small></h4>
                            </div>

                            <!-- Buttons -->
                            <div class="mt-4">
                                <div class="btn btn-primary btn-lg btn-flat">
                                    <i class="fas fa-cart-plus fa-lg mr-2"></i> Add to Cart
                                </div>
                                <div class="btn btn-default btn-lg btn-flat">
                                    <i class="fas fa-heart fa-lg mr-2"></i> Add to Wishlist
                                </div>
                            </div>

                            <!-- Share -->
                            <div class="mt-4 product-share">
                                @foreach (['facebook-square', 'twitter-square', 'envelope-square', 'rss-square'] as $icon)
                                    <a href="#" class="text-gray">
                                        <i class="fab fa-{{ $icon }} fa-2x"></i>
                                    </a>
                                @endforeach
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
