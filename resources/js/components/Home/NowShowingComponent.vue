<template>
    <!-- now showing -->
    <div id="now-showing-slide">
        <div class="fs-3 container mt-5 mb-4 d-flex justify-content-center align-items-center fw-bold"
            style="color: #72be43; border: 1px solid; width: 460px; border-radius: 10px;">
            NOW SHOWING/SNEAK SHOW
        </div>
        <div v-if="loading" class="text-center">
            <p>Đang tải phim...</p>
        </div>
        <div v-else>
            <div class="swiper-container" style="width: 96%;">
                <div class="cart-wrapper">
                    <ul class="card-list swiper-wrapper" style="list-style: none; display: flex; flex-wrap: wrap;">
                        <li v-for="film in films" :key="film.id" class="card-item swiper-slide" style="flex: 0 0 23%; margin: 1%;">
                            <img :src="film.images" :alt="film.name" style="border-radius: 10px; width: 100%; height: 400px; object-fit: cover;">
                            <a :href="'/movie/' + film.id"
                                class="buy_now d-inline-flex justify-content-center p-2 fs-5 align-items-center text-white"
                                style="display:none; background-color:#72be43; border: 1px solid #72be43; border-radius:10px; z-index: 1; text-decoration: none; width:200px;visibility: hidden;">
                                Mua vé ngay<i class='bx bx-cart-add'></i></a>
                            <div class="continue"><i class='bx bx-play-circle'></i></div>
                            <div class="meta mt-3 mb-3">
                                <span class="age-limit text-white p-1 rounded-3 me-1"
                                    style="background-color:rgb(254, 45, 45); font-size: 12px">
                                    {{ getAgeLimit(film) }}
                                </span>
                                <span class="format text-white p-1 rounded-3"
                                    style="background-color:#72be43; font-size: 12px">2D</span>
                            </div>
                            <h4>
                                <a :href="'/movie/' + film.id" class="fw-bold"
                                    style="text-decoration: none; color:#72be43; font-size: 20px; ">
                                    {{ film.name }}
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import homeService from '../../services/homeService';

export default {
    name: 'NowShowingComponent',
    data() {
        return {
            films: [],
            loading: true
        }
    },
    methods: {
        async fetchFilms() {
            try {
                this.loading = true;
                // const response = await homeService.getFilms();
                const response = await homeService.getNowShowingFilms();
                console.log('Dữ liệu phim:', response);
                this.films = response.films || [];
                this.loading = false;
            } catch (error) {
                console.error('Lỗi khi tải dữ liệu phim:', error);
                this.loading = false;
            }
        },
        
        getAgeLimit(film) {
            return film.age_limit || 'T18';
        }
    },
    mounted() {
        this.fetchFilms();
    }
}
</script>
