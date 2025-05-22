<template>
    <div class="container mt-4" style="margin-left: 28%;" v-if="loaded">
        <div class="card p-3 col-6 d-flex flex-column justify-content-center align-items-center">
            <div>
                <h6 style="text-align: center;"><strong>{{ theaterName }}</strong></h6>
                <p style="text-align: center;">
                    Screen 1 - {{ showtimeDate }} - Suất chiếu: {{ showtimeTime }}
                </p>
                <h6 style="color: #72be43">{{ filmName }}</h6>
                <div class="separator"></div>
                <h5 class="d-flex justify-content-between">
                    <span>Tổng tiền:</span>
                    <span><strong id="total">{{ totalCost }}</strong> <b> VND</b></span>
                </h5>
                <div class="separator"></div>
            </div>
            <button class="btn w-100" style="background-color:#72be43; color:white" @click="handlePayment" :disabled="processing">
                <span v-if="!processing">THANH TOÁN (4/4)</span>
                <span v-else>Đang xử lý...</span>
            </button>
            <a href="#" class="text-decoration-none d-block text-center mt-2">← Trở lại</a>
            <div v-if="successMsg" class="alert alert-success mt-3 d-flex flex-column align-items-center">
                {{ successMsg }}
                <button class="btn btn-outline-success mt-3" @click="goHome">Về trang chủ</button>
            </div>
            <div v-if="errorMsg" class="alert alert-danger mt-3">{{ errorMsg }}</div>
        </div>
    </div>
    <div v-else class="text-center mt-5">Đang tải dữ liệu...</div>
</template>

<script>
import bookingTicketService from '../../services/bookingTicketService';
import axiosInstance from '../../axious/axious2';

export default {
    name: "Step4Component",
    data() {
        return {
            loaded: false,
            processing: false,
            successMsg: '',
            errorMsg: '',
            theaterName: '',
            filmName: '',
            showtimeDate: '',
            showtimeTime: '',
            totalCost: 0,
            theaterId: null,
            showtimeId: null,
            filmId: null,
            selectedSeats: [],
            combos: {},
        };
    },
    methods: {
        getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        },
        goHome() {
            window.location.href = '/';
        },
        async fetchStep4() {
            try {
                this.theaterId = this.getQueryParam('theaterId');
                this.showtimeId = this.getQueryParam('showtimeId');
                this.filmId = this.getQueryParam('filmId');
                this.selectedSeats = (this.getQueryParam('selectedSeats') || '').split(',');
                this.totalCost = parseInt(this.getQueryParam('totalCost')) || 0;
// Lấy combos từ query string
                const urlParams = new URLSearchParams(window.location.search);
                let combos = {};
                for (const [key, value] of urlParams.entries()) {
                    if (key.startsWith('combo[')) {
                        const id = key.match(/combo\[(\d+)\]/)[1];
                        combos[id] = parseInt(value);
                    }
                }
                this.combos = combos;

                // Gọi API step4
                const res = await bookingTicketService.postStep4({
                    theaterId: this.theaterId,
                    showtimeId: this.showtimeId,
                    filmId: this.filmId,
                    selectedSeats: this.selectedSeats.join(','),
                    totalCost: this.totalCost,
                    combo: this.combos
                });
                if (res.data.status === 200) {
                    this.filmName = res.data.film_name;
                    this.theaterName = res.data.theater_name;
                    const startTime = res.data.showtime.start_time;
                    this.showtimeDate = startTime ? startTime.substring(0, 10) : '';
                    const tmp = startTime ? startTime.substring(11, 16) : '';
                    this.showtimeTime = tmp ? `${tmp.substring(0, 2)}h${tmp.substring(3)}` : '';
                }
                this.loaded = true;
            } catch (err) {
                this.loaded = true;
                this.errorMsg = 'Lỗi lấy dữ liệu bước 4';
            }
        },
        async handlePayment() {
            this.processing = true;
            this.successMsg = '';
            this.errorMsg = '';
            try {
                // Gửi yêu cầu xác nhận đặt vé và gửi mail
                const res = await axiosInstance.post('/user/send-success-booking-email', {
                    theaterId: this.theaterId,
                    showtimeId: this.showtimeId,
                    filmId: this.filmId,
                    selectedSeats: this.selectedSeats,
                    totalCost: this.totalCost,
                    combos: this.combos
                });
                if (res.data.status === 200) {
                    this.successMsg = 'Đặt vé thành công! Vui lòng kiểm tra email của bạn.';
                } else {
                    this.errorMsg = res.data.message || 'Có lỗi xảy ra khi thanh toán.';
                }
            } catch (err) {
                this.errorMsg = 'Có lỗi xảy ra khi thanh toán.';
            }
            this.processing = false;
        }
    },
    mounted() {
        this.fetchStep4();
    }
};
</script>

<style scoped>
.separator {
    border-top: 1px solid #ddd;
    margin: 15px 0;
}
</style>
