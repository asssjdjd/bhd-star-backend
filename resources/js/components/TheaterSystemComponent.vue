<template>
    <div class="container mb-5">
        <div class="col-inner">
            <div id="text-775696433" class="text">
                <h2 class="mb-4">Hệ thống rạp</h2>
            </div>
        </div>
        <div class="row mt-5" style="width: 100%;">
            <div
                v-for="theater in theaters"
                :key="theater.id"
                class="col-12 col-md-6 col-lg-3 mb-4"
            >
                <div class="card ps-3 pe-3 pt-2 border-0">
                    <div class="thumb">
                        <a :href="`/theater/${theater.id}`">
                            <img
                                class="card-img-top lazy"
                                style="width: 100%; border-radius: 10px;"
                                :data-src="theater.image"
                                :alt="theater.name"
                                ref="lazyImages"
                            >
                        </a>
                    </div>
                    <div class="info pt-3">
                        <a href="#" class="text-decoration-none">
                            <h4 class="title" style="font-size: large;">{{ theater.name }}</h4>
                        </a>
                    </div>
                    <div class="stack mt-4">
                        <a
                            :href="`/theater/${theater.id}`"
                            class="btton primary me-3"
                            style="float: left; font-size: 15px;"
                        >Thông tin chi tiết</a>
                        <span class="ms-3 share" style="text-transform: uppercase;">
                            <b>Chia sẻ</b>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border: 1px solid #72be43; margin-left: 5%; margin-right: 5%; margin-top: 0px;">
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "TheaterSystemComponent",
    data() {
        return {
            theaters: [],
        };
    },
    mounted() {
        this.fetchTheaters();
    },
    methods: {
        async fetchTheaters() {
            try {
                const res = await axios.get('/api/user/theater-system');
                if (res.data.status === 200) {
                    // Nếu API trả về phân trang, lấy data từ res.data.theaters.data
                    this.theaters = res.data.theaters.data || res.data.theaters;
                    this.$nextTick(this.lazyLoadImages);
                }
            } catch (e) {
                // Xử lý lỗi nếu cần
            }
        },
        lazyLoadImages() {
            const images = Array.from(this.$el.querySelectorAll('img.lazy'));
            if ('IntersectionObserver' in window) {
                let observer = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            let img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            observer.unobserve(img);
                        }
                    });
                });
                images.forEach(img => observer.observe(img));
            } else {
                // Fallback cho trình duyệt cũ
                images.forEach(img => {
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                });
            }
        }
    }
};
</script>