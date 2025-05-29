<template>
    <div class="container mt-4" v-if="loaded">
        <div class="row">
            <div class="col-md-8">
                <div class="col-inner">
                    <div id="text-775696433" class="text d-flex justify-content-center mt-4">
                        <h2 class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"
                            style="color:#72be43; border: 1px solid #72be43; border-radius: 10px;">
                            Concession
                        </h2>
                    </div>
                </div>
                <div class="list-group">
                    <div
                        v-for="combo in foodCombos"
                        :key="combo.id"
                        class="list-group-item d-flex justify-content-between align-items-center"
                    >
                        <div>
                            <img :src="combo.image" width="50" alt="Popcorn"> {{ combo.name }}
                        </div>
                        <div>
                            <span>Giá bán : </span>
                            <strong :id="'valuecombo' + combo.id">{{ combo.price }}</strong><b> VND</b>
                        </div>
                        <div>
                            <button class="btn btn-outline-secondary" @click="updateQuantity(combo.id, -1)">-</button>
                            <span :id="'combo' + combo.id" :food-id="combo.id" class="mx-2">{{ selectedCombos[combo.id] || 0 }}</span>
                            <button class="btn btn-outline-success" @click="updateQuantity(combo.id, 1)">+</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <h6><strong>{{ theaterName }}</strong></h6>
                    <p>
                        Screen 1 - {{ showtimeDate }} - Suất chiếu: {{ showtimeTime }}
                    </p>
                    <h6 style="color : #72be43">{{ filmName }}</h6>
                    <div class="separator"></div>
                    <p>
                        <span class="badge bg-primary">P</span>
                        <span class="badge bg-warning text-dark">LỒNG TIẾNG</span>
                        <span class="badge bg-secondary">2D</span>
                    </p>
                    <h5>
                        Tổng tiền: <strong id="total">{{ totalCost }}</strong> <b> VND</b>
                    </h5>
                    <div class="separator"></div>
                    <button class="btn w-100" style="background-color:#72be43; color:white" @click="goToStep4">
                        THANH TOÁN (3/4)
                    </button>
                    <a href="#" class="text-decoration-none d-block text-center mt-2">← Trở lại</a>
                    <p id="countdown" class="countdown text-center">{{ countdownText }}</p>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="text-center mt-5">Đang tải dữ liệu...</div>
</template>

<script>
import bookingTicketService from '../../services/bookingTicketService';

export default {
    name: "Step3Component",
    data() {
        return {
            loaded: false,
            foodCombos: [],
            selectedCombos: {},
            totalCost: 0,
            baseCost: 0,
            theaterId: null,
            showtimeId: null,
            filmId: null,
            selectedSeats: [],
            filmName: '',
            theaterName: '',
            showtimeDate: '',
            showtimeTime: '',
            countdown: 379,
            countdownTimer: null,
        };
    },
    computed: {
        countdownText() {
            const minutes = Math.floor(this.countdown / 60);
            const seconds = this.countdown % 60;
            return `Còn lại ${minutes} phút, ${seconds} giây`;
        }
    },
    methods: {
        getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        },
        async fetchStep3() {
            try {
                // Lấy params từ URL
                this.theaterId = this.getQueryParam('theaterId');
                this.showtimeId = this.getQueryParam('showtimeId');
                this.filmId = this.getQueryParam('filmId');
                this.selectedSeats = (this.getQueryParam('selectedSeats') || '').split(',');
                this.totalCost = parseInt(this.getQueryParam('totalCost')) || 0;
                this.baseCost = this.totalCost;

                const res = await bookingTicketService.postStep3({
                    theaterId: this.theaterId,
                    showtimeId: this.showtimeId,
                    filmId: this.filmId,
                    selectedSeats: this.selectedSeats,
                    totalCost: this.totalCost
                });
                if (res.data.status === 200) {
                    this.foodCombos = res.data.food_combos;
                    this.filmName = res.data.film_name;
                    this.theaterName = res.data.theater_name;
                    // Xử lý ngày giờ suất chiếu
                    const startTime = res.data.showtime.start_time;
                    this.showtimeDate = startTime ? startTime.substring(0, 10) : '';
                    const tmp = startTime ? startTime.substring(11, 16) : '';
                    this.showtimeTime = tmp ? `${tmp.substring(0, 2)}h${tmp.substring(3)}` : '';
                }
                this.loaded = true;
            } catch (err) {
                this.loaded = true;
                alert('Lỗi lấy dữ liệu bước 3');
            }
        },
        updateQuantity(comboId, change) {
            const current = this.selectedCombos[comboId] || 0;
            let newQuantity = current + change;
            if (newQuantity < 0) newQuantity = 0;
            this.selectedCombos[comboId] = newQuantity; 

            // Tính lại tổng tiền
            let total = this.baseCost;
            for (const id in this.selectedCombos) {
                const combo = this.foodCombos.find(c => c.id == id);
                if (combo) {
                    total += (this.selectedCombos[id] || 0) * combo.price;
                }
            }
            this.totalCost = total;
        },
        goToStep4() {
            // Tạo chuỗi query từ selectedCombos
            let comboParams = Object.keys(this.selectedCombos)
                .filter(id => this.selectedCombos[id] > 0)
                .map(id => `combo[${id}]=${this.selectedCombos[id]}`)
                .join('&');

            let url = `/step4?theaterId=${this.theaterId}&showtimeId=${this.showtimeId}&filmId=${this.filmId}&totalCost=${this.totalCost}&selectedSeats=${this.selectedSeats.join(',')}`;
            if (comboParams) {
                url += `&${comboParams}`;
            }
            window.location.href = url;
        },
        startCountdown() {
            this.countdownTimer = setInterval(() => {
                if (this.countdown > 0) {
                    this.countdown--;
                }
            }, 1000);
        }
    },
    mounted() {
        this.fetchStep3();
        this.startCountdown();
    },
    beforeUnmount() {
        clearInterval(this.countdownTimer);
    }
};
</script>

<style scoped>
.separator {
    border-top: 1px solid #ddd;
    margin: 15px 0;
}
.discounted-price {
    text-decoration: line-through;
    color: gray;
}
.countdown {
    color: red;
    font-weight: bold;
}
</style>
