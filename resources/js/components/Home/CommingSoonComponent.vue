<template>
    <!-- comming soon -->
    <div id="comming-soon">
        <div class="pt-5">
            <div class="col-inner">
                <div id="text-775696433" class="text d-flex justify-content-center mt-4">
                    <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3" style="color:#72be43; border: 1px solid #72be43; border-radius: 10px;">SẮP KHỞI CHIẾU</h2>
                </div>
            </div>
    
            <div v-if="loading" class="text-center">
                <p>Đang tải phim...</p>
            </div>
            <div v-else class="swiper mb-5" id="coming-soon">
                <div class="cart-wrapper4">
                    <ul class="card-list swiper-wrapper">
                        <li v-for="film in films" :key="film.id" class="card-item swiper-slide">
                            <a :href="'step1/movie/' + film.id" class="card-link" style="background: transparent; padding:4px;">
                                <img :src="film.images" :alt="film.name" style="border-radius: 10px;">
                                <div class="continue"><i class='bx bx-play-circle'></i></div>
                                <div style="color: #72be43" class="card-content fw-bold mt-2">
                                    <span>{{ limitText(film.name, 20) }}</span>
                                    <p class="d-inline-flex align-items-center" style="color:grey">
                                        <span>Thể loại phim:</span>
                                        <a href="#" class="fw-bold" style="text-decoration: none; color:#72be43;">
                                            {{ film.type_name || 'Chưa phân loại' }}
                                        </a>
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
import homeService from '../../services/homeService';
// Đảm bảo đã cài đặt swiper: npm install swiper
import Swiper from 'swiper';
import { Navigation, Pagination, Scrollbar } from 'swiper/modules';
// Import CSS của Swiper
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default {
    name: 'ComingSoonComponent',
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
                const response = await homeService.getComingSoonFilms();
                console.log('Dữ liệu phim sắp chiếu:', response);
                this.films = response.films || [];
                this.loading = false;
                
                // Khởi tạo Swiper sau khi dữ liệu đã được tải
                this.$nextTick(() => {
                    this.initSwiper();
                });
            } catch (error) {
                console.error('Lỗi khi tải dữ liệu phim sắp chiếu:', error);
                this.loading = false;
            }
        },
        
        initSwiper() {
            // Hủy Swiper cũ nếu đã tồn tại
            if (this.swiper) {
                this.swiper.destroy();
            }
            
            // Khởi tạo Swiper mới
            this.swiper = new Swiper('.cart-wrapper4', {
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
                    300: {
                        slidesPerView: 2,
                    },
                    600: {
                        slidesPerView: 3,
                    },
                    900: {
                        slidesPerView: 4,
                    },
                    1200: {
                        slidesPerView: 5,
                    },
                },
            });
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
    transition: all 0.3s ease;
}

.continue {
    position: absolute;
    top: 40%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 3rem;
    color: #72be43;
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
    height: 300px;
    object-fit: cover;
}

.card-link {
    text-decoration: none;
    display: block;
}
</style>