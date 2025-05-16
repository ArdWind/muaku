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

    <header>
        <nav class="glass-nav">
            <!-- logo -->
            <div class="HeaderLogo">
                <img class="Logo1" src="/asset/cust/ico1.png" alt="Logo">
            </div>

            <div class="HeaderMenu">
                <a href="">Home</a>
                <a href="">Contacts</a>
                <a href="">Info</a>
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
                        <button>SEE MORE</button>
                        <button>SUBSCRIBE</button>
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
                        <button>SEE MORE</button>
                        <button>SUBSCRIBE</button>
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
                        <button>SEE MORE</button>
                        <button>SUBSCRIBE</button>
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
                        <button>SEE MORE</button>
                        <button>SUBSCRIBE</button>
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
    <main>
        @yield('content')
    </main>

    {{-- JavaScript --}}
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/cust/CustApp.js') }}"></script>

    {{-- Tambahan script dari halaman anak --}}
    @stack('scripts')
</body>

</html>
