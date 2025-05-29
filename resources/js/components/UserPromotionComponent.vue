<template>
    <div class="pt-5" :style="backgroundStyle">
        <div class="col-inner">
            <div id="text-775696433" class="text d-flex justify-content-center mt-4">
                <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"
                    style="color:#72be43; border: 1px solid #72be43; border-radius: 10px;">
                    KHUYẾN MÃI
                </h2>
            </div>
        </div>
        <div class="swiper mb-5" style="width: 96%;">
            <div class="cart-wrapper2">
                <ul class="card-list swiper-wrapper" style="list-style: none;">
                    <li v-for="promotion in promotions" :key="promotion.id" class="card-item swiper-slide">
                        <a href="#" class="card-link" style="background: transparent;">
                            <img :src="promotion.image" class="card-image" />
                            <h4 class="cart-title">{{ promotion.title }}</h4>
                            <p>{{ limitText(promotion.description, 200) }}</p>
                        </a>
                    </li>
                </ul>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev fw-bold mb-5" style="color:#72be43"></div>
                <div class="swiper-button-next fw-bold mb-5" style="color:#72be43"></div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import Swiper from 'swiper';
import { Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

export default {
    name: "UserPromotionComponent",
    data() {
        return {
            promotions: [],
            swiper: null
        };
    },
    computed: {
        backgroundStyle() {
            return {};
        }
    },
    methods: {
        limitText(text, max) {
            if (!text) return '';
            return text.length > max ? text.substring(0, max) + '...' : text;
        },
        initSwiper() {
            if (this.swiper) this.swiper.destroy();
            this.swiper = new Swiper('.cart-wrapper2', {
                modules: [Navigation, Pagination],
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
                breakpoints: {
                    0: { slidesPerView: 1 },
                    700: { slidesPerView: 2 },
                    1050: { slidesPerView: 3 },
                },
            });
        }
    },
    mounted() {
        axios.get('/api/user/promotion').then(res => {
            if (res.data.status === 200) {
                this.promotions = res.data.promotions.data;
                this.$nextTick(() => this.initSwiper());
            }
            console.log(this.promotions);
        });
    },
    beforeUnmount() {
        if (this.swiper) this.swiper.destroy();
    }
};
</script>


<style scoped>
.card-item {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    padding: 16px;
    margin-bottom: 16px;
    height: 100%;
}
.card-image {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 12px;
}
.cart-title {
    color: #72be43;
    font-weight: bold;
    font-size: 1.1rem;
    margin-bottom: 8px;
}
.swiper {
    padding-bottom: 40px;
}
</style>
