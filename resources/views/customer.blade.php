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
                @auth
                    {{-- Tampilan untuk user yang sudah login --}}
                    <a href="{{ route('order.customer.pay') }}">Booking</a>
                @else
                    {{-- Tampilan untuk user yang belum login (guest) --}}
                    <a href="/login">Booking</a>
                @endauth

                <a href="#info-usaha">Info</a>
                <a href="#footer">Contacts</a>
            </div>

            <!-- Kanan: Hallo, User + Logout -->
            <div class="HeaderUser">
                @auth
                    {{-- Tampilan untuk user yang sudah login --}}
                    <a>Hallo, {{ auth()->user()->name }}</a>
                    <a href="/logout" class="nav-link">Logout</a>
                @else
                    {{-- Tampilan untuk user yang belum login (guest) --}}
                    <a href="/login" class="nav-link">Login</a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- carousel -->
    <div class="carousel" id="products-carousel">
        <!-- list item -->
        <div class="list">
            <div class="item">
                <img src="/asset/cust/img1.png">
                <div class="content">
                    <div class="author">Make Up</div>
                    <div class="title">WEDDING</div>
                    <div class="topic">MUA.KU</div>
                    <div class="des">
                        Wujudkan impian pernikahan Anda dengan riasan yang memukau. Kami ahli dalam menciptakan berbagai
                        gaya make up wedding, mulai dari tampilan <strong>klasik nan anggun, modern yang chic, hingga
                            riasan adat yang kaya detail</strong>. Setiap sesi diawali dengan konsultasi mendalam untuk
                        memahami visi Anda, memastikan riasan yang dihasilkan tidak hanya cantik, tetapi juga
                        <strong>sepenuhnya merefleksikan diri Anda</strong>. Percayakan momen sakral ini pada keahlian
                        profesional kami.
                    </div>
                    <div class="buttons">
                        @auth
                            {{-- Tampilan untuk user yang sudah login --}}
                            <a href="{{ route('detail.wedding') }}">
                                <button>SEE MORE</button>
                            </a>
                        @else
                            {{-- Tampilan untuk user yang belum login (guest) --}}
                            <a href="/login">
                                <button>SEE MORE</button>
                            </a>
                        @endauth
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
                        Tampil memukau di samping pengantin wanita adalah impian setiap bridesmaid. Layanan make up
                        bridesmaid kami fokus pada <strong>kecantikan yang selaras dan elegan</strong>, memastikan Anda
                        bersinar tanpa mengalahkan pesona pengantin. Kami menciptakan riasan yang <strong>segar, tahan
                            lama, dan sesuai dengan tema</strong> pernikahan, sekaligus menonjolkan fitur terbaik Anda.
                        Biarkan kami merias Anda dengan sentuhan profesional agar Anda merasa percaya diri dan cantik
                        sempurna di hari istimewa sahabat Anda.
                    </div>
                    <div class="buttons">
                        @auth
                            {{-- Tampilan untuk user yang sudah login --}}
                            <a href="{{ route('detail.braid') }}">
                                <button>SEE MORE</button>
                            </a>
                        @else
                            {{-- Tampilan untuk user yang belum login (guest) --}}
                            <a href="/login">
                                <button>SEE MORE</button>
                            </a>
                        @endauth
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
                        Hari lamaran adalah langkah awal menuju babak baru kehidupan Anda. Layanan make up engagement
                        day kami dirancang untuk menciptakan tampilan yang <strong>memancarkan kebahagiaan, keanggunan,
                            dan kesegaran</strong>. Kami memahami Anda ingin tampil cantik alami namun tetap istimewa di
                        momen ini. Dengan sentuhan profesional, kami akan menonjolkan fitur terbaik Anda, memastikan
                        riasan yang <strong>flawless, tahan lama, dan sempurna</strong> untuk diabadikan dalam setiap
                        foto dan kenangan.
                    </div>
                    <div class="buttons">
                        @auth
                            {{-- Tampilan untuk user yang sudah login --}}
                            <a href="{{ route('detail.eng') }}">
                                <button>SEE MORE</button>
                            </a>
                        @else
                            {{-- Tampilan untuk user yang belum login (guest) --}}
                            <a href="/login">
                                <button>SEE MORE</button>
                            </a>
                        @endauth
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
                        Rayakan momen kelulusan Anda dengan penampilan yang sempurna! Layanan make up wisuda kami
                        didesain untuk menciptakan tampilan yang <strong>fresh, ceria, dan fotogenik</strong>, agar Anda
                        bersinar di hari spesial ini. Kami fokus pada riasan yang <strong>tahan lama dan
                            nyaman</strong>, memungkinkan Anda menikmati setiap prosesi tanpa khawatir. Dengan sentuhan
                        profesional, Anda akan tampil percaya diri dan siap mengukir kenangan indah di hari bersejarah
                        wisuda Anda.
                    </div>
                    <div class="buttons">
                        @auth
                            {{-- Tampilan untuk user yang sudah login --}}
                            <a href="{{ route('detail.grad') }}">
                                <button>SEE MORE</button>
                            </a>
                        @else
                            {{-- Tampilan untuk user yang belum login (guest) --}}
                            <a href="/login">
                                <button>SEE MORE</button>
                            </a>
                        @endauth
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

    <!-- Section Info Usaha -->
    <section id="info-usaha" class="info-usaha py-5">
        <div class="container">
            <h1 class="display-5 fw-bold">Tentang <span
                    style="color: #f1683a;font-weight: bold;
                    line-height: 1.3em;">MUA.KU</span>
            </h1>
            {{-- <h2 class="text-center mb-4 section-title">Tentang MUA.KU</h2> --}}
            <div class="row align-items-center">
                <div class="col-md-5 text-center mb-4 mb-md-0">
                    <img src="/asset/cust/yov.jpeg" alt="Youvanda - Founder MUA.KU"
                        class="img-fluid rounded-circle shadow-lg owner-photo">
                    <h4 class="mt-3">Youvanda</h4>
                    <p class="text-muted">Founder & Professional Makeup Artist</p>
                </div>
                <div class="col-md-7">
                    <p class="lead text-justify">
                        <strong>MUA.KU</strong> berdiri sejak tahun 2022 sebagai wujud dedikasi dari
                        <strong>Youvanda</strong>, seorang <strong>Makeup Artist profesional</strong>
                        yang bertekad menghadirkan kecantikan terbaik bagi setiap klien. Dengan sentuhan rias yang
                        <strong>elegan, flawless, dan sesuai karakter pribadi</strong>, Youvanda berkomitmen untuk
                        menyempurnakan
                        setiap momen spesial Anda.
                    </p>
                    <p class="text-justify mb-3">
                        Berbekal pengalaman luas dalam industri kecantikan, Youvanda menguasai beragam teknik makeup,
                        mulai dari tampilan <strong>natural, glamor, hingga riasan pengantin adat</strong> yang memukau.
                        Kualitas
                        karyanya tak perlu diragukan lagi, terbukti dari berbagai <strong>penghargaan dan kemenangan
                            dalam
                            perlombaan makeup bergengsi</strong> yang telah diraihnya.
                    </p>
                    <p class="text-justify">
                        Kami di MUA.KU melayani berbagai kebutuhan riasan untuk acara-acara penting Anda, termasuk
                        <strong>pernikahan, wisuda, lamaran, dan beragam event istimewa lainnya.</strong> Percayakan
                        momen berharga
                        Anda kepada MUA.KU untuk hasil yang tak terlupakan.
                    </p>
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Konten Halaman --}}
    <main id="products" class="product-section">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer id="footer" class="site-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>MUA.KU</h4>
                <p>Perumahan mangunjaya lestari 2 kb 26 no 11 kecamatan tambun selatan kabupaten bekasi</p>
                <p>Email: youvandamaysha@gmail.com</p>
                <p>Telepon: +62 896-7390-6621</p>
            </div>

            <div class="footer-section">
                <h4>Media Sosial</h4>
                <p>
                    <a href="https://www.instagram.com/yovanda.makeup" target="_blank">
                        <i class="fab fa-instagram"></i> Instagram: @yovanda.makeup
                    </a>
                </p>
                <p>
                    <a href="https://wa.me/6289673906621" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp: +62 896-7390-6621
                    </a>
                </p>
                <p>
                    <a href="mailto:youvandamaysha@gmail.com">
                        <i class="fas fa-envelope"></i> Email: youvandamaysha@gmail.com
                    </a>
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} MUA.KU All rights reserved.
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
