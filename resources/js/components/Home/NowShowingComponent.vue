<template>
    <!-- now showing -->
    <div id="now-showing-slide">
        <div class="fs-3 container mt-5 mb-4 d-flex justify-content-center align-items-center fw-bold"
            style="color: #72be43; border: 1px solid; width: 460px; border-radius: 10px;">
            ĐANG KHỞI CHIẾU
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
                            <a :href="'step1/' + film.id"
                                class="buy_now d-inline-flex justify-content-center  align-items-center text-white"
                                style="display:none; background-color:#72be43; border: 1px solid #72be43; border-radius:10px; z-index: 1; text-decoration: none; width:150px; height: 50px; visibility: hidden;">
                                Mua vé ngay</a>

                            <div class="continue"><i class='bx bx-play-circle'></i></div>
                            <div class="meta mt-3 mb-3">
                                <span class="age-limit text-white p-1 rounded-3"
                                    style="background-color:rgb(254, 45, 45); font-size: 12px">
                                    {{ getAgeLimit(film) }}
                                </span>
                                <span class="type text-white p-1 rounded-3 bg-dark" style="font-size: 12px">LỒNG
                                    TIẾNG</span>
                                <span class="format text-white p-1 rounded-3"
                                    style="background-color:#72be43; font-size: 12px">2D</span>
                            </div>
                            <h4>
                                <a :href="'page/' + film.id" class="fw-bold"
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

                    <!-- If we need navigation buttons -->
                    <div class="swiper-button-prev fw-bold mb-5" style="color:#72be43"></div>
                    <div class="swiper-button-next fw-bold mb-5" style="color:#72be43"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import homeService from '../../services/homeService';
// Đảm bảo đã cài đặt swiper: npm install swiper
import Swiper from 'swiper';
import { Navigation, Pagination, Scrollbar } from 'swiper/modules';
// Import CSS của Swiper (nếu cần)
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default {
    name: 'NowShowingComponent',
    data() {
        return {
            films: [],
            loading: true,
            swiper: null
        }
    },
    methods: {
        async fetchFilms() {
            try {
                this.loading = true;
                const response = await homeService.getFilms();
                console.log('Dữ liệu phim:', response);
                this.films = response.data.films || [];
                this.loading = false;

                // Khởi tạo Swiper sau khi dữ liệu đã được tải
                this.$nextTick(() => {
                    this.initSwiper();
                });
            } catch (error) {
                console.error('Lỗi khi tải dữ liệu phim:', error);
                this.loading = false;
            }
        },

        initSwiper() {
            // Hủy Swiper cũ nếu đã tồn tại
            if (this.swiper) {
                this.swiper.destroy();
            }

            // Khởi tạo Swiper mới
            this.swiper = new Swiper('.cart-wrapper', {
                modules: [Navigation, Pagination, Scrollbar],
                loop: true,
                spaceBetween: 30,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                    },
                    350: {
                        slidesPerView: 2,
                    },
                    700: {
                        slidesPerView: 3,
                    },
                    1050:{
                        slidesPerView: 4,
                    },
                    1400:{
                        slidesPerView: 5,
                    },
                },
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
        this.fetchFilms();
    },
    beforeUnmount() {
        // Hủy Swiper khi component bị hủy
        if (this.swiper) {
            this.swiper.destroy();
        }
    }
}
</script>

<style scoped>
/* CSS cho component */
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
    left: 70px !important
    /* transform: translate(-50%, -50%); */
}

.continue {
    position: absolute;
    top: 40%;
    right : 60%;
    transform: translate(-50%, -50%);
    color:#72be43;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;

}

.card-item:hover .continue {
    opacity: 1;
}

/* Đảm bảo hình ảnh có kích thước phù hợp */
.card-item img {
    width: 100%;
    height: 400px;
    object-fit: cover;
}
</style>
