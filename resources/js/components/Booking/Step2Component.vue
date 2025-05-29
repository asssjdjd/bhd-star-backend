<template>
    <div>
        <div id="introduce" class="mb-5">
            <div class="fs-4 p-3 fw-bold d-flex justify-content-center align-item-center">Bước 2: Chọn ghế</div>
            <div class="card container mb-4" style="border-radius: 15px;">
                <div class="row d-inline-flex justify-content-center align-item-center">
                    <div class="col-2 pt-4 pb-4">
                        <img :src="film?.images" style="max-width: 100%; height: auto; border-radius: 10px; padding-left: 5px;" alt="">
                    </div>
                    <div class="col-10 pt-4 pb-4">
                        <div class="introduce-title fs-5 fw-bold" style="color: #72be43;">{{ film?.name }}</div>
                        <p class="mt-3" style="font-size: 17px">{{ film?.description }}</p>
                        <div class="introduce-infor mb-2">
                            <p><span class="meta-title">Đạo diễn:</span> <a href="#">{{ film?.name_director }}</a></p>
                            <p><span class="meta-title">Diễn viên:</span> <a href="#">{{ film?.name_actor }}</a></p>
                            <p><span class="meta-title">Thể loại:</span> <a href="#">{{ film?.category_name }}</a></p>
                            <p>
                                <span class="meta-title">Khởi chiếu:</span> {{ formatDate(film?.launch_date) }} |
                                <span class="meta-title">Thời lượng:</span> {{ film?.duration }} phút
                            </p>
                        </div>
                        <a class="btn btn-sm p-2 fw-bold mt-2 button-introduce"
                           href="/"
                           style="border: 1px solid #72be43; border-radius: 10px; font-size:17px; text-transform: uppercase; color : #72be43">
                            ← Chọn phim khác
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- booking ticket -->
        <div class="container">
            <div id="booking-ticket">
                <div class="row mt-5">
                    <div class="col-7 mb-5" style="margin-left:10px;">
                        <!-- màn hình -->
                        <div class="screen pb-5 d-flex justify-content-center align-item-center">
                            <img src="/asset/img/booking-ticket/seatMapHeader.png" alt="" style="width: 90%; height: auto; object-fit: cover;">
                        </div>
                        <!-- loại ghế -->
                        <div class="legend mb-4 d-flex justify-content-center">
                            <div class="legend-item me-2"><i class="fa-solid fa-couch standard"></i> Standard</div>
                            <div class="legend-item me-2"><i class="fa-solid fa-couch vip"></i> VIP</div>
                            <div class="legend-item me-2"><i class="fa-solid fa-couch couple"></i> Couple</div>
                            <div class="legend-item me-2"><i class="fa-solid fa-couch sold"></i> Đã bán</div>
                            <div class="legend-item me-2"><i class="fa-solid fa-couch selected"></i> Đang chọn</div>
                        </div>
                        <!-- sơ đồ ghế -->
                        <div class="seat-map mb-4">
                            <!-- Các hàng thường -->
                            <div v-for="row in rows.filter(r => r !== 'F')" :key="row" class="seat-row d-flex align-items-center">
                                <div class="row-label me-2">{{ row }}</div>
                                <div class="d-flex">
                                    <div
                                        v-for="col in cols"
                                        :key="col"
                                        v-show="shouldRenderSeat(row, col)"
                                        :class="seatClass(row, col)"
                                        :data-id="`${row}${col}`"
                                        @click="toggleSeat(row, col)"
                                    >
                                        <i class="fa-solid fa-couch" style="font-size: 27px;"></i>
                                    </div>
                                </div>
                            </div>
                            <!-- Hàng ghế đôi (F) -->
                            <div class="seat-row d-flex align-items-center" v-if="rows.includes('F')">
                                <div class="row-label me-2">F</div>
                                <div class="d-flex">
                                    <div
                                        v-for="col in cols"
                                        :key="col"
                                        v-show="coupleSeats.includes(`F${col}`)"
                                        :class="seatClass('F', col)"
                                        :data-id="`F${col}`"
                                        @click="toggleSeat('F', col)"
                                        style="margin-right: 2px;"
                                    >
                                        <i class="fa-solid fa-couch" style="font-size: 27px;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto ms-5">
                        <div class="card border p-4" style="width: 100%; border-radius: 10px;">
                            <h4 class="fw-bold fs-5" style="color: black;">{{ theaterName }}</h4>
                            <span class="session-info">
                                16/05/2025 - Suất chiếu: 14h20
                            </span>
                            <hr>
                            <div class="mt-1 mb-1" style="width: 100%;" id="content-buy">
                                <h3 class="film-title fs-5 mt-3 fw-bold" style="color: #72be43;">{{ film?.name }}</h3>
                                <div class="meta mb-3">
                                    <span class="age-limit text-white p-1 rounded-3 me-2"
                                        style="background-color:rgb(254, 45, 45); font-size: 12px">T18</span>
                                    <span class="type text-white p-1 rounded-3 bg-dark" style="font-size: 12px">LỒNG TIẾNG</span>
                                    <span class="format text-white p-1 rounded-3 ms-2"
                                        style="background-color:#72be43; font-size: 12px">2D</span>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <div v-if="selectedSeats.length === 0" class="border border-danger rounded-1 p-1 ps-3 pe-3 mb-2 mt-2">
                                    Bạn chưa chọn ghế nào. Vui lòng chọn ghế.
                                </div>
                                <div v-else>
                                    <div class="fs-5 fw-bold pb-2">Tổng Số Tiền : {{ cost }} VND</div>
                                    <div class="btn btn-md fw-bold text-white"
                                         style="background: linear-gradient(to bottom, #388E1B, #72be00); width: 100%;">
                                        <a href="#" @click.prevent="goToStep3" style="text-decoration: none;" class="text-white">Vui lòng chọn bước số 3</a>
                                    </div>
                                </div>
                                <span>
                                    Còn lại <span class="time" style="color:red">{{ countdownText }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import bookingTicketService from '../../services/bookingTicketService';

export default {
    name: "Step2Component",
    data() {
        return {
            film: null,
            seats: [],
            soldSeats: [],
            vipSeats: [],
            coupleSeats: [],
            selectedSeats: [],
            cost: 0,
            rows: ["A", "B", "C", "D", "E", "F"],
            cols: 14,
            theaterId: null,
            showtimeId: null,
            filmId: null,
            countdown: 7 * 60,
            countdownTimer: null,
            theaterName: '',
            showtimeDate: '',
            showtimeTime: '',
        };
    },
    computed: {
        countdownText() {
            const minutes = Math.floor(this.countdown / 60);
            const seconds = this.countdown % 60;
            return `${minutes} phút ${seconds} giây`;
        }
    },
    methods: {
        async fetchStep2() {
            try {
                const res = await bookingTicketService.postStep2({
                    theater_id: this.theaterId,
                    showtime_id: this.showtimeId,
                    film_id: this.filmId
                });
                if (res.data.status === 200) {
                    this.seats = res.data.seats;
                    this.soldSeats = res.data.soldSeats;
                    this.vipSeats = res.data.vipSeats;
                    this.coupleSeats = res.data.coupleSeats;
                    this.film = res.data.film;
                }
            } catch (err) {
                console.error('Lỗi lấy dữ liệu bước 2:', err);
            }
        },
        shouldRenderSeat(row, col) {
            const seatId = `${row}${col}`;
            // Chỉ render ghế nếu là ghế hợp lệ (giống logic blade)
            if (!this.soldSeats.includes(seatId) && !this.vipSeats.includes(seatId) && !this.coupleSeats.includes(seatId) && row === 'F') {
                return false;
            }
            return true;
        },
        getSeatStatus(row, col) {
            const seatId = `${row}${col}`;
            // Nếu API trả về this.seats với {id, status}, ưu tiên lấy status
            const seat = this.seats.find(s => s.id === seatId);
            if (seat && seat.status) return seat.status;
            // Nếu không có, fallback về soldSeats
            if (this.soldSeats.includes(seatId)) return 'Sold';
            return '';
        },
        seatClass(row, col) {
            const seatId = `${row}${col}`;
            const status = this.getSeatStatus(row, col);
            if (status === 'Sold') {
                return [
                    'seat',
                    'sold',
                    this.selectedSeats.includes(seatId) ? 'selected' : ''
                ].join(' ');
            }
            return [
                'seat',
                this.vipSeats.includes(seatId) ? 'vip' : '',
                this.coupleSeats.includes(seatId) ? 'couple' : '',
                (!this.vipSeats.includes(seatId) && !this.coupleSeats.includes(seatId) && row !== 'F') ? 'standard' : '',
                this.selectedSeats.includes(seatId) ? 'selected' : ''
            ].join(' ');
        },
        toggleSeat(row, col) {
             const seatId = `${row}${col}`;
            const status = this.getSeatStatus(row, col);
            if (status === 'Sold') return;
            if (this.soldSeats.includes(seatId)) return;
            const isSelected = this.selectedSeats.includes(seatId);
            let seatType = 'standard';
            if (this.vipSeats.includes(seatId)) seatType = 'vip';
            else if (this.coupleSeats.includes(seatId)) seatType = 'couple';

            if (isSelected) {
                // Bỏ chọn
                this.selectedSeats = this.selectedSeats.filter(s => s !== seatId);
                if (seatType === 'vip') this.cost -= 60000;
                else if (seatType === 'standard') this.cost -= 40000;
                else if (seatType === 'couple') this.cost -= 100000;
            } else {
                // Chọn mới
                this.selectedSeats.push(seatId);
                if (seatType === 'vip') this.cost += 60000;
                else if (seatType === 'standard') this.cost += 40000;
                else if (seatType === 'couple') this.cost += 100000;
            }
        },
        goToStep3() {
            if (this.selectedSeats.length === 0) return;
            const url = `/step3?selectedSeats=${this.selectedSeats.join(',')}&totalCost=${this.cost}&theaterId=${this.theaterId}&showtimeId=${this.showtimeId}&filmId=${this.filmId}`;
            window.location.href = url;
        },
        formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return `${d.getDate().toString().padStart(2, '0')}/${(d.getMonth() + 1).toString().padStart(2, '0')}/${d.getFullYear()}`;
        },
        updateCountdown() {
            if (this.countdown > 0) {
                this.countdown--;
                localStorage.setItem("timeLeft", this.countdown);
            }
        },
        getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }
    },
    mounted() {
        // Lấy params từ URL
        this.theaterId = this.getQueryParam('theater_id');
        this.showtimeId = this.getQueryParam('showtime_id');
        this.filmId = this.getQueryParam('film_id');
        this.fetchStep2();

        // Lấy tên rạp, screen, ngày, giờ (có thể lấy từ API hoặc truyền qua query nếu cần)
        // this.theaterName = ...;
        // this.screenName = ...;
        // this.showtimeDate = ...;
        // this.showtimeTime = ...;

        // Countdown
        this.countdown = parseInt(localStorage.getItem("timeLeft")) || 7 * 60;
        this.countdownTimer = setInterval(() => {
            this.updateCountdown();
        }, 1000);
    },
    beforeUnmount() {
        clearInterval(this.countdownTimer);
    }
};
</script>

<style scoped>
    #booking-ticket i {
        font-size: 25px;
    }
</style>
