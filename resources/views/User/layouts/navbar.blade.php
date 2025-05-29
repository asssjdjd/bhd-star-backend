<!-- banner -->
<div id="top-banner">
    <a href="{{ route('home')}}">
        <img src="{{asset('asset/img/Ngang-02.jpg')}}" alt="header" width="100%" height="125px">
    </a>

</div>
<!-- navbar -->
<div id="navbar-header" class="sticky-top">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fw-bold">
        <div class="container">
            <!-- button navbar -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ps-5">
                    <li class="nav-item">
                        <div class="container">
                            <a href="{{ route('home')}}">
                                <img src="{{asset('asset/img/logo2024.png')}}" alt="logo_navbar" height="35" width="160">
                            </a>
                        </div>

                    </li>
                    <!-- dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" class="navbarDropdow" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            ĐANG KHỞI CHIẾU
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item " href="{{ route('movie_schedule') }}">LỊCH CHIẾU PHIM</a></li>
                            <li><a class="dropdown-item" href="{{ route('theater_schedule') }}">LỊCH CHIẾU RẠP</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop') }}">ĐỒ ĂN/COMBO</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('promotion') }}">KHUYẾN MÃI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">DỊCH VỤ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" class="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            VỀ BHD STAR
                        </a>
                        <ul class="dropdown-menu fw-bold fs-8" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('theater_system') }}">HỆ THỐNG RẠP</a></li>
                            <li><a class="dropdown-item" href="#">VỀ CHÚNG TÔI</a></li>
                            <li><a class="dropdown-item" href="#">TUYỂN DỤNG</a></li>
                        </ul>
                    </li>

                </ul>

                <!-- form navbar register -->
                <li class="d-flex" id="right-navbar">
                    <a title="Đăng ký/Đăng nhập" href="{{ route('login')}}"
                        class="text-decoration-none text-white p-2 rounded-3 fw-normal position-relative"
                        aria-expanded="false">
                        <span id="hover_nav" class="btn btn-md text-white p-2 rounded-3 fw-bold"
                            style="border: 1px solid #e3f2c0; background-color: #72be43;">
                            Đăng nhập/Đăng ký
                        </span>
                    </a>
                </li>

                <li class="account-item has-icon nav-item list-unstyled" id="user-navbar" style="display:none;">
                    <a href="/user-detail" class="account-link account-login text-decoration-none " title="Tài khoản">
                        <i class="image-icon circle">
                            <img width="40px" src="{{ asset('asset/img/no-user.jpg')}}">
                        </i>
                        <span class="header-account-title text-dark" id="user-name">
                            <!-- Sẽ được JS cập nhật -->
                        </span>
                    </a>
                    <a class="lougout-link text-decoration-none text-danger" href="#" id="logout-btn">Thoát</a>
                </li>
            </div>
        </div>
    </nav>
</div>
