<template>
    <!-- hot news -->
    <div id="hot-new">
        <div class="pt-5" style="background-image: url(./asset/img/khuyenmai/promotionBg.jpg);">
            <div class="col-inner">
                <div id="text-775696433" class="text d-flex justify-content-center mt-4">
                    <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3" style="color:#72be43; border: 1px solid #72be43; border-radius: 10px;">TIN NỔI BẬT</h2>
                </div>
            </div>
            <!-- card - wrapper -->
            <div class="swiper mb-5 container">
                <div class="cart-wrapper3 container">
                    <ul class="card-list swiper-wrapper border-0">
                        <li class="card-item swiper-slide d-flex">
                            <a href="#" class="card-link">
                                <img src="https://www.bhdstar.vn/wp-content/uploads/2025/02/COMBOSLDO-01-min.jpg"
                                    class="card-image">
                            </a>
                        </li>

                        <li class="card-item swiper-slide d-flex">
                            <a href="#" class="card-link">
                                <img src="https://www.bhdstar.vn/wp-content/uploads/2024/09/z6098497568270_f2fa708435c9ba93ce1fa26f55729c3f.jpg"
                                    class="card-image">
                                <h4 class="cart-title fw-bold fs-6"></h4>
                            </a>
                        </li>
                    </ul>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev fw-bold mb-5" style="color:#72be43; margin-left: 60px"></div>
                    <div class="swiper-button-next fw-bold mb-5" style="color:#72be43"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HotNewsComponent'
}
</script>
