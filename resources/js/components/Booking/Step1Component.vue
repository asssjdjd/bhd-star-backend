<template>
    <div>
        <div class="fs-4 p-3 fw-bold d-flex justify-content-center align-item-center">Bước 1: Chọn thời gian và địa điểm</div>
        <div v-if="film" class="card container mb-4" style="border-radius: 15px;">
            <div class="row d-inline-flex justify-content-center align-item-center">
                <div class="col-2 pt-4 pb-4">
                    <img :src="film.images" style="max-width: 100%; height: auto; border-radius: 10px; padding-left: 5px;" alt="">
                </div>
                <div class="col-10 pt-4 pb-4">
                    <div class="introduce-title fs-5 fw-bold" style="color: #72be43;">{{ film.name }}</div>
                    <p class="mt-3" style="font-size: 17px">{{ film.description }}</p>
                    <div class="introduce-infor mb-2">
                        <p><span class="meta-title">Đạo diễn:</span> <a href="#">{{ film.name_director }}</a></p>
                        <p><span class="meta-title">Diễn viên:</span> <a href="#">{{ film.name_actor }}</a></p>
                        <p><span class="meta-title">Thể loại:</span> <a href="#">{{ film.category_name }}</a></p>
                        <p>
                            <span class="meta-title">Khởi chiếu:</span> {{ formatDate(film.launch_date) }} |
                            <span class="meta-title">Thời lượng:</span> {{ film.duration }} phút
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

        <div class="container mb-4 d-flex">
            <div class="card card-left col-8" style="border-radius: 15px;">
                <div v-if="showtimes.length === 0 || showtimes === 'empty'" style="margin: 40px; font-size: 20px">
                    Không có suất chiếu nào. Vui lòng chọn ngày khác.
                </div>
                <div v-else>
                    <div v-for="theater in theaters" :key="theater.id" class="mb-4" style="margin: 30px 30px 0 30px;">
                        <div class="mt-list-widget" style="margin-bottom: 20px;">
                            <ul>
                                <li>
                                    <a href="#" class="text-decoration-none">{{ theater.name }}<br>{{ theater.address }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="row row-small mb-3">
                            <div
                                v-for="showtime in showtimesByTheater[theater.id]"
                                :key="showtime.id"
                                class="col-4 medium-4 small-12 large-3"
                            >
                                <div class="col-inner">
                                    <div class="session-item film-item">
                                        <div class="time text-center">
                                            <a class="text-decoration-none"
                                            :href="`/step2?theater_id=${theater.id}&showtime_id=${showtime.id}&film_id=${film.id}`"
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
                        <span>{{ monthYear }}</span>
                        <button @click="nextMonth">&gt;</button>
                    </div>
                    <div class="calendar-days">
                        <div>2</div> <div>3</div> <div>4</div> <div>5</div> <div>6</div> <div>7</div> <div>CN</div>
                    </div>
                    <div class="calendar-grid" style="display: grid; grid-template-columns: repeat(7, 1fr);">
                        <div v-for="cell in calendarCells" :key="cell.key"
                             :class="cell.class"
                             @click="cell.isDay && selectDay(cell.day)">
                            {{ cell.text }}
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
    name: "Step1Component",
    data() {
        return {
            film: null,
            showtimes: [],
            theaters: [],
            filmId: null,
            selectedDate: null,
            currentDate: new Date(),
        };
    },
    computed: {
        monthYear() {
            return `Tháng ${this.currentDate.getMonth() + 1} ${this.currentDate.getFullYear()}`;
        },
        calendarCells() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const cells = [];
            // Tạo khoảng trống trước ngày đầu tiên
            for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) {
                cells.push({ key: `empty-${i}`, text: '', isDay: false, class: '' });
            }
            // Đổ số ngày vào lịch
            for (let day = 1; day <= daysInMonth; day++) {
                let isActive = this.selectedDate &&
                    this.selectedDate.getFullYear() === year &&
                    this.selectedDate.getMonth() === month &&
                    this.selectedDate.getDate() === day;
                cells.push({
                    key: `day-${day}`,
                    text: day,
                    isDay: true,
                    class: isActive ? 'active-day' : '',
                    day: day
                });
            }
            return cells;
        },
        showtimesByTheater() {
            const map = {};
            this.theaters.forEach(theater => {
                map[theater.id] = this.showtimes.filter(st => st.theater_id === theater.id);
            });
            return map;
        }
    },
    methods: {
        async fetchStep1() {
            try {
                const res = await bookingTicketService.getStep1(this.filmId);
                if (res.data.status === 200) {
                    this.film = res.data.film;
                    this.showtimes = res.data.showtimes;
                    this.theaters = res.data.theaters;
                }
            } catch (err) {
                console.error('Lỗi lấy dữ liệu bước 1:', err);
            }
        },
        formatDate(dateStr) {
            if (!dateStr) return '';
            const d = new Date(dateStr);
            return `${d.getDate().toString().padStart(2, '0')}/${(d.getMonth() + 1).toString().padStart(2, '0')}/${d.getFullYear()}`;
        },
        prevMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.currentDate = new Date(this.currentDate); // force reactivity
        },
        nextMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.currentDate = new Date(this.currentDate); // force reactivity
        },
        selectDay(day) {
            this.selectedDate = new Date(this.currentDate.getFullYear(), this.currentDate.getMonth(), day);
            this.sendDateToServer(this.selectedDate);
        },
        async sendDateToServer(date) {
            // Gửi ngày lên backend để lấy showtime và theater mới
            const formattedDate = `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()}`;
            try {
                const res = await fetch('/api/user/senday', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ date: formattedDate, film_id: this.filmId })
                });
                const data = await res.json();
                this.showtimes = data.showtimes;
                this.theaters = data.theaters;
            } catch (err) {
                console.error('Lỗi lấy lịch chiếu theo ngày:', err);
                this.showtimes = [];
                this.theaters = [];
            }
        }
    },
    mounted() {
        // Lấy filmId từ URL
        const pathParts = window.location.pathname.split('/');
        this.filmId = pathParts[pathParts.length - 1];
        this.fetchStep1();
    }
};
</script>

<style scoped>
.active-day {
    background-color: #72be43;
    color: white;
    border-radius: 50%;
}
.calendar-grid div {
    cursor: pointer;
    padding: 5px;
    text-align: center;
}
a{
    text-decoration: none;
    color: #72be43;
}
</style>
