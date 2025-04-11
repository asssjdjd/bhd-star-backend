@extends('User.main')
@section('content')
<div id="now-showing-slide">
    <div class="fs-3  container mt-5 mb-4 d-flex justify-content-center align-items-center fw-bold "
        style="color: #72be43; border: 1px solid; width: 460px; border-radius: 10px;">
        NOW SHOWING/SNEAK SHOW
    </div>

        <div class="swiper " style = "width: 96%;">
            <div class="cart-wrapper">
                <ul class="card-list swiper-wrapper" style="list-style: none;">
                    <li class="card-item swiper-slide ">
                        <img src="./asset/img/nowshowing/anh1.jpg" alt="..." style="border-radius: 10px;">
                        <a href="#"
                            class="buy_now d-inline-flex justify-content-center p-2 fs-5 align-items-center text-white"
                            style="display:none; background-color:#72be43; border: 1px solid #72be43; border-radius:10px; z-index: 1; text-decoration: none; width:200px;visibility: hidden;">
                            Mua vé ngay<i class='bx bx-cart-add'></i></a>
                        <div class="continue"><i class='bx bx-play-circle'></i></div>
                        <div class="meta mt-3 mb-3">
                            <span class="age-limit text-white p-1 rounded-3"
                                style="background-color:rgb(254, 45, 45); font-size: 12px">T18</span>
                            <span class="type text-white p-1 rounded-3 bg-dark" style="font-size: 12px">LỒNG
                                TIẾNG</span>
                            <span class="format text-white p-1 rounded-3"
                                style="background-color:#72be43; font-size: 12px">2D</span>
                        </div>
                        <h4>
                            <a href="http://" class="fw-bold"
                                style="text-decoration: none; color:#72be43; font-size: 20px; ">wolf man:nguời
                                sói</a>
                        </h4>
                        <div class="cats">
                            Thể loại phim:
                            <a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                        </div>
                    </li>
                    
                   
                </ul>
                
                <div class="swiper-pagination"></div>

                <!-- If we need navigation buttons -->

                <div class="swiper-button-prev fw-bold mb-5" style = "color:#72be43"></div>
                <div class="swiper-button-next fw-bold mb-5" style = "color:#72be43"></div>

            </div>


        </div>
    </div>
</div>

<!-- special combo -->

<div class="pt-5">
    <div class="col-inner">
        <div id="text-775696433" class="text d-flex justify-content-center mt-4">
            <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"  style = "color:#72be43; border : 1px solid #72be43; border-radius: 10px;">COMBO ĐẶC BIỆT</h2>
        </div>
    </div>

    <!-- card - wrapper -->
     <div class="swiper mb-5">
        <div class="cart-wrapper2">
            <ul class="card-list swiper-wrapper">
                <li class="card-item swiper-slide d-flex" >
                    <a href="#" class="card-link" >
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/09/combo-conan-moi.jpg" 
                            class="card-image" style="width: 400px; height: 400px; object-fit: cover;">
                        <h4 class="cart-title fw-bold fs-6">
                            COMBO “CONAN – THÁM TỬ LỪNG DANH”
                        </h4>
                        <p style = "font-size: 16px;">
                            Mua combo bắp nước kèm 1 sản phẩm Conan với giá cực hời
                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide d-flex" >
                    <a href="#" class="card-link" >
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/COMBOSLDO-01-min.jpg" 
                            class="card-image" style="width: 400px; height: 400px; object-fit: cover;">
                        <h4 class="cart-title fw-bold fs-6">
                            MÙA YÊU THƯƠNG, SAN SẺ NGỌT NGÀO
                        </h4>
                        <p style = "font-size: 16px;">
                            MÙA YÊU THƯƠNG, SAN SẺ NGỌT NGÀO 1 Bắp rang bùng nổ, 1 Nước ngọt ngào, 1 Hộp socola cặp đôi: Giá chỉ 149,000đ.
                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide d-flex" >
                    <a href="#" class="card-link" >
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/11/467403530_1008787251287761_8367159137306975953_n.jpg" 
                            class="card-image" style="width: 400px; height: 400px; object-fit: cover;">
                        <h4 class="cart-title fw-bold fs-6">
                            COMBO XMAS SIÊU CUTE TẠI BHD STAR
                        </h4>
                        <p style = "font-size: 16px;">
                            GIÁNG SINH LUNG LINH TẠI BHD STAR Chào đón Giáng Sinh tại BHD Star với bộ ly túi xinh iu nè cả nhà ơi Mau mau đến rạp BHD Star ngay để đón Giáng Sinh sớm nhé các bạn ơi Sản phẩm đã có mặt tại cụm rạp BHD Star TP.HCM Đặt vé tại: bhdstar.vn […]

                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide d-flex" >
                    <a href="#" class="card-link" >
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/10/Ao-thun-Sai-gon-ink-vuong-2.jpg" 
                            class="card-image" style="width: 400px; height: 400px; object-fit: cover;">
                        <h4 class="cart-title fw-bold fs-6">
                            COMBO “ÁO THUN BHDS x SAIGONINK” SIÊU CHẤT
                        </h4>
                        <p style = "font-size: 16px;">
                            Công nghệ in hiện đại mang lại những sản phẩm áo thun BST Halloween của BHDS & SaigonInk có hình in sắc nét, màu sắc sinh động
                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide d-flex" >
                    <a href="#" class="card-link" >
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/09/z6098497568270_f2fa708435c9ba93ce1fa26f55729c3f.jpg" 
                            class="card-image" style="width: 400px; height: 400px; object-fit: cover;">
                        <h4 class="cart-title fw-bold fs-6">
                            COMBO “CONAN – THÁM TỬ LỪNG DANH”
                        </h4>
                        <p style = "font-size: 16px;">
                            Mua combo bắp nước kèm túi tole hoặc quai xách ly siêu xinh với giá siêu ưu đãi
                        </p>
                    </a>
                </li>

              
                
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev fw-bold" style = "color:#72be43"></div>
            <div class="swiper-button-next fw-bold " style = "color:#72be43"></div>
        </div>

     </div>
</div>

<!-- discount-->
<div class="pt-5" style = "background-image: url(./asset/img/khuyenmai/promotionBg.jpg);">
    <div class="col-inner">
        <div id="text-775696433" class="text d-flex justify-content-center mt-4">
            <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"  style = "color:#72be43; border : 1px solid #72be43; border-radius: 10px;">KHUYẾN MÃI</h2>
        </div>
    </div>

    <!-- card - wrapper -->
     <div class="swiper mb-5">
        <div class="cart-wrapper2">
            <ul class="card-list swiper-wrapper">
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/11/COMBO-34K-PHAM-HUNG-1536x864.jpg" class="card-image">
                        <h4 class="cart-title">
                            U22 MUA COMBO BẮP NƯỚC GIÁ CHỈ 34K – CHỈ TẠI BHD STAR PHẠM HÙNG
                        </h4>
                        <p>
                            U22 MUA COMBO BẮP NƯỚC GIÁ CHỈ 34K Chỉ có tại BHD Star Phạm Hùng Các bạn U22 đâu rồi tập trung qua rạp BHD Star Phạm Hùng nhanh nèeee,
                            combo bắp nước mà giá chỉ có 34k thôi đó chời ơi không bây giờ thì bao giờ nữa hảaaa Địa chỉ:Tầng 4, Satra Centre […]
                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/01/PEP1920x1080.jpg" class="card-image">
                        <h4 class="cart-title">
                            ĐÃI BẠN SIÊU THÂN
                        </h4>
                        <p>
                            ĐÃI BẠN SIÊU THÂN + Tặng ngay 01 PEPSI “ĐÃ KHÁT” khi mua 2 vé xem phim suất chiếu trước 19h. + Chỉ với 59.000đ có ngay COMBO “ĐÃ KHÁT ĐÃ THÈM” (1 Bắp + 1 nước).
                            * Ưu đãi áp dụng từ: 04.01.2025 – 28.01.2025. * Áp dụng cho tất cả các cụm rạp […]

                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/01/PEP1920x1080.jpg" class="card-image">
                        <h4 class="cart-title">
                            ĐÃI BẠN SIÊU THÂN
                        </h4>
                        <p>
                            ĐÃI BẠN SIÊU THÂN + Tặng ngay 01 PEPSI “ĐÃ KHÁT” khi mua 2 vé xem phim suất chiếu trước 19h. + Chỉ với 59.000đ có ngay COMBO “ĐÃ KHÁT ĐÃ THÈM” (1 Bắp + 1 nước).
                            * Ưu đãi áp dụng từ: 04.01.2025 – 28.01.2025. * Áp dụng cho tất cả các cụm rạp […]

                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/12/SUPSALE1920x1080.jpg" class="card-image">
                        <h4 class="cart-title">
                            CƠN BÃO “SALE” SIÊU KHỦNG TẠI BHD STAR
                        </h4>
                        <p>
                            ĐÓN NHẬN CƠN BÃO “SALE” SIÊU KHỦNG KHIẾP TẠI BHD STAR CINEPLEX. + Tặng ngay 01 PEPSI (trị giá 36.000đ) khi mua 2 vé xem phim bất kì. + 
                            Chỉ với 59.000đ có ngay COMBO “ĐÃ KHÁT ĐÃ THÈM” (1 Bắp + 1 nước). * Ưu đãi áp dụng từ: 04.01.2024 – 28.01.2025 (Không giới […]
                        </p>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/11/466793530_1003149731851513_661564586689858699_n.jpg" class="card-image">
                        <h4 class="cart-title">
                            KHUYẾN MÃI ĐẶC BIỆT KHI XEM PHIM LINH MIÊU TẠI BHD STAR
                        </h4>
                        <p>
                            CHÀO ĐÓN SIÊU BÃO LINH MIÊU SẮP ĐỔ BỘ TẠI BHD STAR Siêu ưu đãi cho đội nhóm khi đến xem phim tại BHD Star Cinplex từ ngày 11.11 – 18.11.2024 
                            Thể lệ chương trình:Mỗi nhóm 3 người khi mua vé xem phim tại BHD Star sẽ được tặng ngay 1 VÉ XEM LINH MIÊU *Lưu ý: […]
                        </p>
                    </a>
                </li>
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev fw-bold mb-5" style = "color:#72be43 "></div>
            <div class="swiper-button-next fw-bold mb-5" style = "color:#72be43"></div>
        </div>

     </div>
</div>

<!-- comming soon -->
<div class="pt-5" >
    <div class="col-inner">
        <div id="text-775696433" class="text d-flex justify-content-center mt-4">
            <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"  style = "color:#72be43; border : 1px solid #72be43; border-radius: 10px;">COMING SOON</h2>
        </div>
    </div>

    <!-- card - wrapper -->
     <div class="swiper mb-5" id = "coming-soon">
        <div class="cart-wrapper4">

            <ul class="card-list swiper-wrapper">
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue1"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue1"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue1"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue1"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue1"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                </li>
                <li class="card-item swiper-slide" >
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                    <a href="#" class="card-link" style = "background: transparent; padding:4px;">
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-17.jpg" style = "border-radius: 10px;">
                        <div class="continue1"><i class='bx bx-play-circle'></i></div>
                        <div style="color: #72be43" class ="card-content fw-bold mt-2">
                            <span>MISSION IMPOSSIBLE</span>
                            <p class = "d-inline-flex align-items-center" style = "color:grey">
                                <span>Thể loại phim:</span><a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">Horror</a>
                            </p>
                        </div>
                    </a>
                </li>
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev fw-bold mb-5" style = "color:#72be43 "></div>
            <div class="swiper-button-next fw-bold mb-5" style = "color:#72be43"></div>
        </div>

     </div>
</div>

<!-- hot news -->
<div class="pt-5 "  style = "background-image: url(./asset/img/khuyenmai/promotionBg.jpg);">
    <div class="col-inner">
        <div id="text-775696433" class="text d-flex justify-content-center mt-4">
            <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"  style = "color:#72be43; border : 1px solid #72be43; border-radius: 10px;">TIN NỔI BẬT</h2>
        </div>
    </div>
    <!-- card - wrapper -->
     <div class="swiper mb-5 container">
        <div class="cart-wrapper3 container">
            <ul class="card-list swiper-wrapper border-0">
                <li class="card-item swiper-slide d-flex" >
                    <a href="#" class="card-link" >
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/COMBOSLDO-01-min.jpg" 
                            class="card-image">
                    </a>
                </li>
        
                <li class="card-item swiper-slide d-flex" >
                    <a href="#" class="card-link" >
                        <img src="https://www.bhdstar.vn/wp-content/uploads/2024/09/z6098497568270_f2fa708435c9ba93ce1fa26f55729c3f.jpg" 
                            class="card-image">
                        <h4 class="cart-title fw-bold fs-6">
                    </a>
                </li>
            </ul>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev fw-bold mb-5" style = "color:#72be43; margin-left : 60px"></div>
            <div class="swiper-button-next fw-bold mb-5" style = "color:#72be43"></div>
        </div>

     </div>
</div>
@endsection