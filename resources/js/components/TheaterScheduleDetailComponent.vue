<template>
    <div>
        <!-- Thông tin rạp -->
        <div id="introduce">
            <div class="card container mb-4" style="border-radius: 15px;">
                <div class="row d-inline-flex justify-content-center align-item-center">
                    <div class="col-3 pt-4 pb-4">
                        <img :src="theater?.image" style="max-width: 100%; height: auto; border-radius: 10px; padding-left: 5px;" alt="">
                    </div>
                    <div class="col-9 pt-4 pb-4">
                        <div class="introduce-title fs-5 fw-bold" style="color: #72be43;">
                            {{ theater?.name }}
                        </div>
                        <p class="mt-3" style="font-size: 17px">{{ theater?.address }}</p>
                        <p class="mt-3" style="font-size: 17px">{{ theater?.phone }}</p>
                        <p class="mt-3" style="font-size: 17px">{{ theater?.email }}</p>
                        <a class="btn btn-sm p-2 fw-bold mt-2 button-introduce"
                            href="/theater-schedule"
                            style="border: 1px solid #72be43; border-radius: 10px; font-size:17px; text-transform: uppercase; color: #72be43">
                            ← Chọn rạp khác
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lịch chiếu và lịch ngày -->
        <div class="container mb-4 d-flex">
            <div class="card card-left col-8" style="border-radius: 15px;">
                <div v-if="loading" style="margin: 40px; font-size: 20px">Đang tải dữ liệu...</div>
                <div v-else-if="showtimes.length === 0" style="margin: 40px; font-size: 20px">
                    Không có suất chiếu nào. Vui lòng chọn ngày khác.
                </div>
                <div v-else class="tmp mb-4" style="margin: 30px 30px 0 30px;">
                    <div v-for="film in films" :key="film.id" class="mt-list-widget" style="margin-bottom: 20px;">
                        <ul>
                            <li>
                                <a href="#" class="text-decoration-none">{{ film.name }}<br>{{ theater?.name }}</a>
                            </li>
                        </ul>
                        <div class="row row-small mb-3 mt-3">
                            <div
                                v-for="showtime in showtimes.filter(s => s.film_id === film.id)"
                                :key="showtime.id"
                                class="col-4 medium-4 small-12 large-3"
                            >
                                <div class="col-inner">
                                    <div class="session-item film-item">
                                        <div class="time text-center">
                                            <a class="text-decoration-none"
                                               href="#"
                                               @click.prevent="goToStep2(theater.id, showtime.id, film.id)"
                                               style="color: #fff">
                                                {{ showtime.start_time.substring(11, 16) }}
                                            </a>
                                        </div>
                                        <div class="meta text-center">
                                            <span class="type">Phụ đề</span>
                                            <span class="format">2D</span>
                                            <span class="first-class" style="display: none;">FIRST CLASS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Calendar -->
            <div class="card card-right col-4" style="border-radius: 15px; margin-left: 20px;">
                <div class="calendar" style="width: 100%;">
                    <div class="calendar-header">
                        <button @click="prevMonth">&lt;</button>
                        <span id="monthYear">Tháng {{ currentMonth + 1 }} {{ currentYear }}</span>
                        <button @click="nextMonth">&gt;</button>
                    </div>
                    <div class="calendar-days">
                        <div>2</div> <div>3</div> <div>4</div> <div>5</div> <div>6</div> <div>7</div> <div>CN</div>
                    </div>
                    <div class="calendar-grid" id="calendarGrid">
                        <div
                            v-for="cell in calendarCells"
                            :key="cell.key"
                            :class="cell.class"
                            @click="cell.isDay && selectDay(cell.day)"
                            style="cursor: pointer;"
                        >
                            {{ cell.text }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axiosInstance from '../axious/axious';

export default {
    name: "TheaterScheduleDetailComponent",
    data() {
        return {
            theater: null,
            films: [],
            showtimes: [],
            loading: true,
            currentDate: new Date(),
            selectedDate: new Date(),
        };
    },
    computed: {
        currentMonth() {
            return this.currentDate.getMonth();
        },
        currentYear() {
            return this.currentDate.getFullYear();
        },
        calendarCells() {
            const year = this.currentYear;
            const month = this.currentMonth;
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const cells = [];
            // Thêm ô trống đầu tháng
            for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) {
                cells.push({ key: `empty-${i}`, text: '', isDay: false, class: '' });
            }
            // Thêm ngày
            for (let day = 1; day <= daysInMonth; day++) {
                let isActive = this.selectedDate &&
                    this.selectedDate.getFullYear() === year &&
                    this.selectedDate.getMonth() === month &&
                    this.selectedDate.getDate() === day;
                let isToday = (() => {
                    const today = new Date();
                    return day === today.getDate() &&
                        month === today.getMonth() &&
                        year === today.getFullYear();
                })();
                cells.push({
                    key: `day-${day}`,
                    text: day,
                    isDay: true,
                    class: [
                        isActive ? 'active-day' : '',
                        isToday ? 'current-day' : ''
                    ].join(' ').trim(),
                    day: day
                });
            }
            return cells;
        },
    },
    methods: {
        fetchSchedule(date = null) {
            this.loading = true;
            const pathParts = window.location.pathname.split('/');
            const theaterId = pathParts[pathParts.length - 1];
            // Lấy ngày hiện tại nếu chưa có date
            let fetchDate = date;
            if (!fetchDate) {
                const today = new Date();
                fetchDate = `${today.getFullYear()}-${today.getMonth() + 1}-${today.getDate()}`;
            }
            // Lấy thông tin rạp lần đầu (GET)
            axiosInstance.get(`/user/theater-schedule-detail/${theaterId}?date=${fetchDate}`)
                .then(res => {
                    if (res.data.status === 200) {
                        this.theater = res.data.theater;
                        this.films = res.data.films || [];
                        this.showtimes = res.data.showtimes || [];
                    }
                    this.loading = false;
                })
                .catch(() => {
                    this.loading = false;
                });
        },
        selectDay(day) {
            if (!day) return;
            this.selectedDate = new Date(this.currentYear, this.currentMonth, day);
            const pathParts = window.location.pathname.split('/');
            const theaterId = pathParts[pathParts.length - 1];
            const date = `${this.currentYear}-${this.currentMonth + 1}-${day}`;
            this.loading = true;
            // Gọi API senday-theater (POST)
            axiosInstance.post('/user/senday-theater', {
                date: date,
                theater_id: theaterId
            }).then(res => {
                this.showtimes = res.data.showtime || [];
                this.films = res.data.films || [];
                if (this.theater && res.data.theaterName) {
                    this.theater.name = res.data.theaterName;
                }
                this.loading = false;
            }).catch(() => {
                this.loading = false;
            });
        },
        isActiveDay(day) {
            return day && day === this.selectedDay;
        },
        isToday(day) {
            const today = new Date();
            return (
                day === today.getDate() &&
                this.currentMonth === today.getMonth() &&
                this.currentYear === today.getFullYear()
            );
        },
       prevMonth() {
            this.currentDate = new Date(this.currentYear, this.currentMonth - 1, 1);
            this.selectedDate = new Date(this.currentYear, this.currentMonth, 1);
            this.fetchSchedule(`${this.currentYear}-${this.currentMonth + 1}-1`);
        },
        nextMonth() {
            this.currentDate = new Date(this.currentYear, this.currentMonth + 1, 1);
            this.selectedDate = new Date(this.currentYear, this.currentMonth, 1);
            this.fetchSchedule(`${this.currentYear}-${this.currentMonth + 1}-1`);
        },
        goToStep2(theaterId, showtimeId, filmId) {
            window.location.href = `/step2?theater_id=${theaterId}&showtime_id=${showtimeId}&film_id=${filmId}`;
        }
    },
    mounted() {
        // Lấy lịch chiếu ngày hiện tại khi load
        this.fetchSchedule();
    }
};
</script>

<style scope>
.active-day {
    background-color: #72be43;
    color: white;
}
</style>