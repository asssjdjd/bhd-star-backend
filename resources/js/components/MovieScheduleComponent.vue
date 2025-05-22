<template>
    <div>
        <!-- NOW SHOWING -->
        <div id="now-showing-slide">
            <div class="fs-3 container mt-5 mb-4 d-flex justify-content-center align-items-center fw-bold"
                style="color: #72be43; border: 1px solid; width: 460px; border-radius: 10px;">
                NOW SHOWING/SNEAK SHOW
            </div>
            <div v-if="loading" class="text-center">
                <p>Đang tải phim...</p>
            </div>
            <div v-else>
                <div class="swiper" style="width: 96%;">
                    <div class="cart-wrapper">
                        <ul class="card-list swiper-wrapper" style="list-style: none;">
                            <li v-for="film in films" :key="film.id" class="card-item swiper-slide">
                                <img :src="film.images" :alt="film.name" style="border-radius: 10px;">
                                <a :href="'/step1/' + film.id"
                                    class="buy_now d-inline-flex justify-content-center align-items-center text-white"
                                    style="display:none; background-color:#72be43; border: 1px solid #72be43; border-radius:10px; z-index: 1; text-decoration: none; width:150px; height: 50px; visibility: hidden;">
                                    Mua vé ngay
                                </a>
                                <div class="continue"><i class='bx bx-play-circle'></i></div>
                                <div class="meta mt-3 mb-3">
                                    <span class="age-limit text-white p-1 rounded-3"
                                        style="background-color:rgb(254, 45, 45); font-size: 12px">
                                        {{ getAgeLimit(film) }}
                                    </span>
                                    <span class="type text-white p-1 rounded-3 bg-dark" style="font-size: 12px">LỒNG TIẾNG</span>
                                    <span class="format text-white p-1 rounded-3"
                                        style="background-color:#72be43; font-size: 12px">2D</span>
                                </div>
                                <h4>
                                    <a :href="'/page/' + film.id" class="fw-bold"
                                        style="text-decoration: none; color:#72be43; font-size: 20px;" :title="film.name">
                                        {{ limitText(film.name, 20) }}
                                    </a>
                                </h4>
                                <div class="cats">
                                    Thể loại phim:
                                    <a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">
                                        {{ film.type_name || 'Chưa phân loại' }}
                                    </a>
                                </div>
                            </li>
                        </ul>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev fw-bold mb-5" style="color:#72be43"></div>
                        <div class="swiper-button-next fw-bold mb-5" style="color:#72be43"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- COMING SOON -->
        <div class="pt-5">
            <div class="col-inner">
                <div id="text-775696433" class="text d-flex justify-content-center mt-4">
                    <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"
                        style="color:#72be43; border : 1px solid #72be43; border-radius: 10px;">COMING SOON</h2>
                </div>
            </div>
            <div class="swiper mb-5" id="coming-soon">
                <div class="cart-wrapper4">
                    <ul class="card-list swiper-wrapper">
                        <li v-for="film in comingSoon" :key="film.id" class="card-item swiper-slide">
                            <a :href="'/page/' + film.id" class="card-link" style="background: transparent; padding:4px;">
                                <img :src="film.images" style="border-radius: 10px;">
                                <div class="continue"><i class='bx bx-play-circle'></i></div>
                                <div style="color: #72be43" class="card-content fw-bold mt-2">
                                    <span>{{ limitText(film.name, 20) }}</span>
                                    <p class="d-inline-flex align-items-center" style="color:grey">
                                        <span>Thể loại phim:</span>
                                        <a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">{{ film.type_name }}</a>
                                    </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev fw-bold mb-5" style="color:#72be43"></div>
                    <div class="swiper-button-next fw-bold mb-5" style="color:#72be43"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import homeService from '../services/homeService';
import Swiper from 'swiper';
import { Navigation, Pagination, Scrollbar } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default {
    name: "MovieScheduleComponent",
    data() {
        return {
            films: [],
            comingSoon: [],
            loading: true,
            swiperNow: null,
            swiperSoon: null
        }
    },
    methods: {
        async fetchData() {
            this.loading = true;
            const res = await homeService.getMovieSchedule();
            this.films = res.data.films || [];
            this.comingSoon = res.data.commingSoon || [];
            this.loading = false;
            this.$nextTick(() => {
                this.initSwiper();
                this.initHover();
            });
        },
        initSwiper() {
            // Now showing
            if (this.swiperNow) this.swiperNow.destroy();
            this.swiperNow = new Swiper('.cart-wrapper', {
                modules: [Navigation, Pagination, Scrollbar],
                loop: true,
                spaceBetween: 30,
                pagination: {
                    el: '.cart-wrapper .swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: '.cart-wrapper .swiper-button-next',
                    prevEl: '.cart-wrapper .swiper-button-prev',
                },
                scrollbar: {
                    el: '.cart-wrapper .swiper-scrollbar',
                },
                breakpoints: {
                    0: { slidesPerView: 1 },
                    350: { slidesPerView: 2 },
                    700: { slidesPerView: 3 },
                    1050: { slidesPerView: 4 },
                    1400: { slidesPerView: 5 },
                },
            });
            // Coming soon
            if (this.swiperSoon) this.swiperSoon.destroy();
            this.swiperSoon = new Swiper('.cart-wrapper4', {
                modules: [Navigation, Pagination],
                loop: true,
                spaceBetween: 30,
                pagination: {
                    el: '.cart-wrapper4 .swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: '.cart-wrapper4 .swiper-button-next',
                    prevEl: '.cart-wrapper4 .swiper-button-prev',
                },
                breakpoints: {
                    0: { slidesPerView: 1 },
                    700: { slidesPerView: 2 },
                    1050: { slidesPerView: 3 },
                },
            });
        },
        initHover() {
            // Hover hiệu ứng "Mua vé ngay" và icon play
            const cardItems = document.querySelectorAll("#now-showing-slide .card-item");
            cardItems.forEach((card) => {
                const buyNow = card.querySelector(".buy_now");
                const continueEl = card.querySelector(".continue");
                card.addEventListener("mouseenter", () => {
                    if (buyNow) {
                        buyNow.style.visibility = "visible";
                        buyNow.style.display = "inline-flex";
                    }
                    if (continueEl) continueEl.style.display = "block";
                });
                card.addEventListener("mouseleave", () => {
                    if (buyNow) {
                        buyNow.style.visibility = "hidden";
                        buyNow.style.display = "none";
                    }
                    if (continueEl) continueEl.style.display = "none";
                });
            });
        },
        getAgeLimit(film) {
            return film.age_limit || 'T18';
        },
        limitText(text, maxLength) {
            if (text && text.length > maxLength) {
                return text.substring(0, maxLength) + '...';
            }
            return text;
        }
    },
    mounted() {
        this.fetchData();
    },
    beforeUnmount() {
        if (this.swiperNow) this.swiperNow.destroy();
        if (this.swiperSoon) this.swiperSoon.destroy();
    }
}
</script>

<style scoped>
.card-item {
    position: relative;
    padding: 0;
    transition: all 0.3s ease;
}
.card-item:hover .buy_now {
    visibility: visible !important;
    display: inline-flex !important;
    position: absolute;
    top: 55%;
    left: 70px !important;
}
.continue {
    position: absolute;
    top: 40%;
    right: 60%;
    transform: translate(-50%, -50%);
    color: #72be43;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.card-item:hover .continue {
    opacity: 1;
}
.card-item img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}
</style>