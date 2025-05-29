<template>
    <div class="container" v-if="theater">
        <div class="row">
            <div class="col-7 p-2 rounded-2" style="border: 1px #72be43 solid;">
                <div class="p-3">
                    <h4 style="color: #72be43;">{{ theater.name?.toUpperCase() }}</h4>
                    <br>
                    <h5>{{ theater.name }}</h5>
                    <ul class="d-flex flex-column gap-3 mt-3">
                        <li><b>Địa điểm:</b> {{ theater.address }}</li>
                        <li><b>Số điện thoại:</b> {{ theater.phone }}</li>
                        <li><b>Email:</b> {{ theater.email }}</li>
                    </ul>
                </div>
                <div class="mt-1 p-3">
                    <img src="https://www.bhdstar.vn/wp-content/uploads/2023/12/LK.png" alt="..." width="100%" height="auto">
                </div>
                <div class="mt-4 p-3">
                    <img src="https://www.bhdstar.vn/wp-content/uploads/2023/12/BHDS.LK_.Ticket-Price-Le.png" alt="..." width="100%" height="auto">
                </div>
                <div class="mt-5">
                    <h6>CÁC QUY ĐỊNH GIÁ VÉ</h6>
                    <ul>
                        <li v-for="(line, idx) in policyLines" :key="idx" style="list-style: none" v-html="line"></li>
                    </ul>
                </div>
            </div>
            <div class="col-5 rounded-2">
                <div class="container">
                    <div style="border: 1px #72be43 solid;" class="p-3">
                        <h4 style="text-align: center;"><b>Địa điểm khác</b></h4>
                        <ul style="list-style: none; color: #72be43" class="d-flex flex-column gap-3 mt-3">
                            <li v-for="item in otherTheaters" :key="item.id">
                                <img src="https://www.bhdstar.vn/wp-content/uploads/2023/08/logo.png" alt=".." width="24px">
                                &nbsp;
                                <a :href="`/theater/${item.id}`" class="text-decoration-none" style="color: #72be43">
                                    {{ item.name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="text-center mt-5">Đang tải dữ liệu rạp...</div>
</template>

<script>
import axios from 'axios';

export default {
    name: "TheaterDetailComponent",
    data() {
        return {
            theater: null,
            otherTheaters: [],
        };
    },
    computed: {
        policyLines() {
            // Tách từng dòng quy định, giữ xuống dòng
            if (!this.theater || !this.theater.policy) return [];
            return this.theater.policy.split('\n').map(line =>
                line.replace(/\r/g, '').replace(/\n/g, '<br>')
            );
        }
    },
    mounted() {
        // Lấy id từ URL (nếu dùng vue-router thì this.$route.params.id)
        const pathParts = window.location.pathname.split('/');
        const id = pathParts[pathParts.length - 1];
        axios.get(`/api/user/theater/${id}`).then(res => {
            if (res.data.status === 200) {
                this.theater = res.data.theater;
                // Loại bỏ rạp hiện tại khỏi danh sách địa điểm khác
                this.otherTheaters = (res.data.theaters || []).filter(t => t.id !== this.theater.id);
            }
        });
    }
};
</script>
