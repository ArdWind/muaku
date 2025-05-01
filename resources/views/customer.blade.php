<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUA.KU</title>
    <link rel="stylesheet" href="{{ asset('asset/cust/CustStyle.css') }}">
    <link rel="icon" href="{{ asset('/asset/cust/icolight.png') }}" type="image/png">
</head>
<body>
    <header>
        {{-- <nav>
            <a href="">Home</a>
            <a href="">Contacts</a>
            <a href="">Info</a>
        </nav> --}}
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
                <a>Hallo, {{auth()->user()->name}}</a>
                <a href="/logout" class="nav-link">
                    <p>Logout</p>
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
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
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
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
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
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
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
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ut sequi, rem magnam nesciunt minima placeat, itaque eum neque officiis unde, eaque optio ratione aliquid assumenda facere ab et quasi ducimus aut doloribus non numquam. Explicabo, laboriosam nisi reprehenderit tempora at laborum natus unde. Ut, exercitationem eum aperiam illo illum laudantium?
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
        <!-- next prev -->

        <div class="arrows">
            <button id="prev"><</button>
            <button id="next">></button>
        </div>
        <!-- time running -->
        <div class="time"></div>
    </div>

    <script src="{{ asset('asset/cust/CustApp.js') }}"></script>
</body>
</html>