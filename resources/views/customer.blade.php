<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUA.KU</title>

    {{-- Bootstrap 4 from AdminLTE --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    {{-- Tambahan CSS dari halaman anak --}}
    @stack('styles')

    {{-- Custom Style --}}
    <link rel="stylesheet" href="{{ asset('asset/cust/CustStyle.css') }}">
    <link rel="icon" href="{{ asset('/asset/cust/icolight.png') }}" type="image/png">
</head>

<body>

    <header id="home">
        <nav class="glass-nav">
            <!-- logo -->
            <div class="HeaderLogo">
                <img class="Logo1" src="/asset/cust/ico1.png" alt="Logo">
            </div>

            <div class="HeaderMenu">
                <a href="#home">Home</a>
                <a href="#products">Products</a>
                <a href="#info-usaha">Info</a>
                <a href="#footer">Contacts</a>
            </div>

            <!-- Kanan: Hallo, User + Logout -->
            <div class="HeaderUser">
                <a>Hallo, {{ auth()->user()->name }}</a>
                <a href="/logout" class="nav-link">
                    Logout
                </a>
            </div>
        </nav>
    </header>

    <!-- carousel -->
    <div class="carousel">
        <!-- list item -->
        <div class="list">
            <div class="item">
                <img src="/asset/cust/img1.png">
                <div class="content">
                    <div class="author">Make Up</div>
                    <div class="title">WEDDING</div>
                    <div class="topic">MUA.KU</div>
                    <div class="des">
                        <!-- lorem 50 -->
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima
                        placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et
                        quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at
                        laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
                    </div>
                    <div class="buttons">
                        <a href="{{ route('detail.wedding') }}">
                            <button>SEE MORE</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="/asset/cust/img2.png">
                <div class="content">
                    <div class="author">Make Up</div>
                    <div class="title">BRIDESMAID</div>
                    <div class="topic">MUA.KU</div>
                    <div class="des">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima
                        placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et
                        quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at
                        laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
                    </div>
                    <div class="buttons">
                        <a href="{{ route('detail.braid') }}">
                            <button>SEE MORE</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="/asset/cust/img3.png">
                <div class="content">
                    <div class="author">Make Up</div>
                    <div class="title">ENGAGEMENT DAY</div>
                    <div class="topic">MUA.KU</div>
                    <div class="des">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima
                        placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et
                        quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at
                        laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
                    </div>
                    <div class="buttons">
                        <a href="{{ route('detail.eng') }}">
                            <button>SEE MORE</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="/asset/cust/img4.png">
                <div class="content">
                    <div class="author">Make Up</div>
                    <div class="title">GRADUATION</div>
                    <div class="topic">MUA.KU</div>
                    <div class="des">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima
                        placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et
                        quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at
                        laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
                    </div>
                    <div class="buttons">
                        <a href="{{ route('detail.grad') }}">
                            <button>SEE MORE</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- list thumnail -->
        <div class="thumbnail">
            <div class="item">
                <img src="/asset/cust/img1.png">
                <div class="content">
                    <div class="title">
                        Wedding
                    </div>
                    <div class="description">
                        Make Up
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="/asset/cust/img2.png">
                <div class="content">
                    <div class="title">
                        Bridesmaid
                    </div>
                    <div class="description">
                        Make Up
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="/asset/cust/img3.png">
                <div class="content">
                    <div class="title">
                        Engagement
                    </div>
                    <div class="description">
                        Make Up
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="/asset/cust/img4.png">
                <div class="content">
                    <div class="title">
                        Graduation
                    </div>
                    <div class="description">
                        Make Up
                    </div>
                </div>
            </div>
        </div>

        {{-- Arrows --}}
        <div class="arrows">
            <button id="prev">&laquo;</button>
            <button id="next">&raquo;</button>
        </div>

        {{-- Time progress --}}
        <div class="time"></div>
    </div>

    {{-- Konten Halaman --}}
    <main id="products" class="product-section">
        @yield('content')
    </main>

    <!-- Section Info Usaha -->
    <section id="info-usaha" class="info-usaha">
        <h2>Tentang MUA.KU</h2>
        <p>
            MUA.KU adalah layanan make up artist profesional yang melayani berbagai acara penting seperti pernikahan,
            wisuda, lamaran, dan lainnya. Kami berkomitmen memberikan hasil terbaik untuk setiap momen spesial Anda.
        </p>
    </section>

    <!-- Footer -->
    <footer id="footer" class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>MUA.KU</h4>
                <p>Jalan Mawar No. 123, Bandung</p>
                <p>Email: info@muaku.id</p>
                <p>Telepon: +62 812-3456-7890</p>
            </div>

            <div class="footer-section">
                <h4>Media Sosial</h4>
                <p><a href="https://instagram.com/muaku_official" target="_blank"><i class="fab fa-instagram"></i>
                        Instagram</a></p>
                <p><a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                </p>
                <p><a href="https://facebook.com/muaku" target="_blank"><i class="fab fa-facebook"></i> Facebook</a>
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} MUA.KU. All rights reserved.
        </div>
    </footer>

    {{-- JavaScript --}}
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/cust/CustApp.js') }}"></script>

    {{-- Tambahan script dari halaman anak --}}
    @stack('scripts')
</body>

</html>
