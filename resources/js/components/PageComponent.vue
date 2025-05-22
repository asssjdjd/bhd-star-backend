<template>
    <div class="container" style="width: 100vw;" v-if="film">
        <div class="row">
            <div class="col-4">
                <img :src="film.images"
                    alt=".." width="100%" height="auto" class="rounded-5">
            </div>
            <div class="col-5">
                <span>
                    <h3 style="color: #72be43;">{{ film.name }}</h3>
                    <br>
                    <p>{{ film.description }}</p>
                    <br>
                    <p>
                        Phân loại:
                        <button class="btn ps-1 pe-1"
                            style="color: white; background-color: red; padding: 2px;">T13</button>
                        Phim phổ biến đến người xem từ 13 tuổi trở lên
                    </p>
                    <p>
                        Định dạng:
                        <button class="btn ps-1 pe-1"
                            style="color: white; background-color: #72be43; padding: 2px;">2D</button>
                    </p>
                    <p>Đạo diễn: <span style="color: #72be43;">{{ film.name_director }}</span></p>
                    <p>Diễn viên: <span style="color: #72be43;">{{ film.name_actor }}</span></p>
                    <p>Thể loại: <span style="color: #72be43;">{{ film.type_name }}</span></p>
                    <p v-if="film.launch_date">Ngày khởi chiếu: {{ formattedDate }}</p>
                    <p>Thời lượng: {{ film.duration }} phút</p>
                    <p>Ngôn ngữ: Phụ đề</p>
                </span>
            </div>
            <div class="col-3">
                <img src="https://www.bhdstar.vn/wp-content/uploads/2025/01/Doc-01.jpg" alt=".." width="100%" height="auto" class="rounded-5">
            </div>
        </div>
        <div v-if="film.video_link && film.video_link !== 'no'" class="mt-5">
            <iframe width="1300" height="730"
                :src="film.video_link"
                :title="film.name"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin"
                allowfullscreen>
            </iframe>
        </div>
        <!-- Nếu có component giảm giá, import và dùng ở đây -->
        <!-- <DiscountComponent /> -->
    </div>
    <div v-else class="text-center mt-5">Đang tải dữ liệu phim...</div>
</template>

<script>
import bookingTicketService from '../services/bookingTicketService';
// import DiscountComponent from './DiscountComponent.vue'; // Nếu có

export default {
    name: "PageComponent",
    // Nếu truyền prop film từ cha thì dùng props: ['film'],
    data() {
        return {
            film: null,
        };
    },
    computed: {
        formattedDate() {
            if (!this.film || !this.film.launch_date) return '';
            const dateParts = this.film.launch_date.split(' ')[0].split('-');
            return `${dateParts[2]}/${dateParts[1]}/${dateParts[0]}`;
        }
    },
    mounted() {
        // Lấy id từ URL (nếu dùng vue-router thì this.$route.params.id)
        const pathParts = window.location.pathname.split('/');
        const filmId = pathParts[pathParts.length - 1];
        bookingTicketService.getStep1(filmId).then(res => {
            if (res.data.status === 200) {
                this.film = res.data.film;
            }
        });
    }
    // components: { DiscountComponent }
};
</script>