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
                            NOW SHOWING
                        </a>
                        
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item " href="#">LỊCH CHIẾU PHIM</a></li>
                            <li><a class="dropdown-item" href="#">LỊCH CHIẾU RẠP</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">ĐỒ ĂN/COMBO</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">KHUYẾN MÃI</a>
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
                            <li><a class="dropdown-item" href="#">HỆ THỐNG RẠP</a></li>
                            <li><a class="dropdown-item" href="#">VỀ CHÚNG TÔI</a></li>
                            <li><a class="dropdown-item" href="#">TUYỂN DỤNG</a></li>
                        </ul>
                    </li>

                </ul>

                <!-- form navbar register -->
                <div class="d-flex" id="right-navbar">
                    <a title="Đăng ký/Đăng nhập" href="#"
                        class="text-decoration-none text-white p-2 rounded-3 fw-normal position-relative"
                        aria-expanded="false">
                        <span id="hover_nav" class="btn btn-md text-white p-2 rounded-3 fw-bold"
                            style="border: 1px solid #e3f2c0; background-color: #72be43;">
                            Đăng nhập/Đăng ký
                        </span>
                        {{-- <div id="nav_dropdown" class="card position-absolute top-5 end-0 fw-bold "
                            style="width: 320px; transform: translateX(20px); display : none; background-color: rgba(44, 44, 44, .29);">
                            <div class="card-body d-flex flex-column justify-content-end pb-4"
                                style="background-color: rgba(44, 44, 44, .29); font-size:14px;">
                                <form id="loginForm" action="{{ route('login')}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Email*</label>
                                        <input name="email" type="email" class="form-control" id="emailInput"
                                            placeholder="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="passwordInput" class="form-label">Mật khẩu*</label>
                                        <input name="password" type="password" class="form-control" id="passwordInput"
                                            placeholder="Mật khẩu" required>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-end p-2" id="button_forgotpassword">
                                        forgot password
                                    </div>

                                    <button type="submit"
                                        class="btn btn-md btn_1 btn-primary w-100 mb-2 border-0 fw-bold mb-3"
                                        style="background-color: #72be43;"> Đăng nhập</button>
                                </form>
                            </div>
                        </div> --}}
                    </a>
                </div>
            </div>
        </div>
    </nav>
</div>