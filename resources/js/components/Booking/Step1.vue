<template>
    <div v-if="hasError" class="alert alert-danger" role="alert">
        {{ errorMessage }}
        <router-link to="/" class="btn btn-primary ml-3">
            Quay lại trang chủ
        </router-link>
    </div>
    <div v-if="film">
        <div id="introduce">
            <div
                class="fs-4 p-3 fw-bold d-flex justify-content-center align-item-center"
            >
                Bước 1: Chọn thời gian và địa điểm
            </div>

            <!-- content-introduce -->
            <div class="card container mb-4" style="border-radius: 15px">
                <div
                    class="row d-inline-flex justify-content-center align-item-center"
                >
                    <div class="col-2 pt-4 pb-4">
                        <img
                            :src="film.images"
                            style="
                                max-width: 100%;
                                height: auto;
                                border-radius: 10px;
                                padding-left: 5px;
                            "
                            alt=""
                        />
                    </div>

                    <div class="col-10 pt-4 pb-4">
                        <div
                            class="introduce-title fs-5 fw-bold"
                            style="color: #72be43"
                        >
                            {{ film.name }}
                        </div>

                        <p class="mt-3" style="font-size: 17px">
                            {{ film.description }}
                        </p>

                        <div class="introduce-infor mb-2">
                            <p>
                                <span class="meta-title">Đạo diễn:</span>
                                <a href="#" title="Director">{{
                                    film.name_director
                                }}</a>
                            </p>
                            <p>
                                <span class="meta-title">Diễn viên:</span>
                                <a href="#" title="Actor">{{
                                    film.name_actor
                                }}</a>
                            </p>
                            <p>
                                <span class="meta-title">Thể loại:</span>
                                <a href="#" title="Category">{{
                                    film.category_name
                                }}</a>
                            </p>
                            <p>
                                <span v-if="film.launch_date" class="meta-title"
                                    >Khởi chiếu:</span
                                >
                                <span v-if="film.launch_date">{{
                                    formatDate(film.launch_date)
                                }}</span>
                                |
                                <span class="meta-title">Thời lượng:</span>
                                {{ film.duration }} phút
                            </p>
                        </div>

                        <router-link
                            class="btn btn-sm p-2 fw-bold mt-2 button-introduce"
                            to="/"
                            style="
                                border: 1px solid #72be43;
                                border-radius: 10px;
                                font-size: 17px;
                                text-transform: uppercase;
                                color: #72be43;
                            "
                        >
                            ← Chọn phim khác
                        </router-link>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-4 d-flex">
            <div class="card card-left col-8" style="border-radius: 15px">
                <div v-if="isEmpty" style="margin: 40px; font-size: 20px">
                    Không có suất chiếu nào. Vui lòng chọn ngày khác.
                </div>
                <div v-else class="mb-4" style="margin: 30px 30px 0 30px">
                    <div
                        v-for="theater in theaters"
                        :key="theater.id"
                        class="mt-4"
                    >
                        <div class="mt-list-widget" style="margin-bottom: 20px">
                            <ul>
                                <li>
                                    <a href="#" class="text-decoration-none"
                                        >{{ theater.name }}<br />{{
                                            theater.address
                                        }}</a
                                    >
                                </li>
                            </ul>
                        </div>
                        <div class="row row-small mb-3">
                            <div
                                v-for="showtime in getShowtimesByTheater(
                                    theater.id
                                )"
                                :key="showtime.id"
                                class="col-4 medium-4 small-12 large-3"
                            >
                                <div class="col-inner">
                                    <div class="session-item film-item">
                                        <div class="time text-center">
                                            <a
                                                class="text-decoration-none"
                                                href="#"
                                                @click.prevent="
                                                    goToStep2(
                                                        theater.id,
                                                        showtime.id,
                                                        film.id
                                                    )
                                                "
                                                style="color: #fff"
                                            >
                                                {{
                                                    formatTime(
                                                        showtime.start_time
                                                    )
                                                }}
                                            </a>
                                        </div>
                                        <div class="meta text-center">
                                            <span class="type">Phụ đề</span>
                                            <span class="format">2D</span>
                                            <span
                                                class="first-class"
                                                style="display: none"
                                                >FIRST CLASS</span
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="card card-right col-4"
                style="border-radius: 15px; margin-left: 20px"
            >
                <div class="calendar" style="width: 100%">
                    <div class="calendar-header">
                        <button @click="prevMonth">&lt;</button>
                        <span
                            >Tháng {{ currentDate.getMonth() + 1 }}
                            {{ currentDate.getFullYear() }}</span
                        >
                        <button @click="nextMonth">&gt;</button>
                    </div>
                    <div class="calendar-days">
                        <div>2</div>
                        <div>3</div>
                        <div>4</div>
                        <div>5</div>
                        <div>6</div>
                        <div>7</div>
                        <div>CN</div>
                    </div>
                    <div class="calendar-grid">
                        <div
                            v-for="(day, index) in calendarDays"
                            :key="index"
                            :class="{
                                'active-day': day.active,
                                'current-day': day.isToday,
                            }"
                            :style="{
                                visibility: day.visible ? 'visible' : 'hidden',
                            }"
                            @click="day.visible && selectDate(day.date)"
                        >
                            {{ day.day }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div
                class="pt-5"
                style="
                    background-image: url('/asset/img/khuyenmai/promotionBg.jpg');
                "
            >
                <div class="col-inner">
                    <div
                        id="text-775696433"
                        class="text d-flex justify-content-center mt-4"
                    >
                        <h2
                            class="title-button mb-4 fw-bold btn fs-3 p-1 ps-3 pe-3"
                            style="
                                color: #72be43;
                                border: 1px solid #72be43;
                                border-radius: 10px;
                            "
                        >
                            TIN NỔI BẬT
                        </h2>
                    </div>
                </div>

                <!-- card - wrapper -->
                <div class="swiper mb-5 container">
                    <div class="cart-wrapper3 container">
                        <ul class="card-list swiper-wrapper border-0">
                            <li class="card-item swiper-slide d-flex">
                                <a href="#" class="card-link">
                                    <img
                                        src="https://www.bhdstar.vn/wp-content/uploads/2025/02/COMBOSLDO-01-min.jpg"
                                        class="card-image"
                                    />
                                </a>
                            </li>

                            <li class="card-item swiper-slide d-flex">
                                <a href="#" class="card-link">
                                    <img
                                        src="https://www.bhdstar.vn/wp-content/uploads/2024/09/z6098497568270_f2fa708435c9ba93ce1fa26f55729c3f.jpg"
                                        class="card-image"
                                    />
                                </a>
                            </li>
                        </ul>
                        <div class="swiper-pagination"></div>
                        <div
                            class="swiper-button-prev fw-bold mb-5"
                            style="color: #72be43; margin-left: 60px"
                        ></div>
                        <div
                            class="swiper-button-next fw-bold mb-5"
                            style="color: #72be43"
                        ></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import bookingTicketService from "../../services/bookingTicketService";
import Swiper from "swiper";
import { Navigation, Pagination } from "swiper/modules";
import "swiper/css";
import "swiper/css/navigation";
import "swiper/css/pagination";

export default {
    name: "Step1",
    props: {
        filmId: {
            type: Number, // Chỉ chấp nhận kiểu Number
            required: true,
            validator: (value) => {
                return Number.isInteger(value) && value > 0; // Đảm bảo là số nguyên dương
            },
        },
    },
    data() {
        return {
            film: null,
            showtimes: [],
            theaters: [],
            isEmpty: false,
            currentDate: new Date(),
            selectedDate: new Date(),
            calendarDays: [],
            swiper: null,
            hasError: false,
            errorMessage: "",
        };
    },
    mounted() {
        // Kiểm tra filmId có phải là số hợp lệ không
        if (
            !Number.isInteger(Number(this.filmId)) ||
            Number(this.filmId) <= 0
        ) {
            this.hasError = true;
            this.errorMessage =
                "ID phim không hợp lệ. Vui lòng chọn phim khác.";
            console.error("Invalid filmId:", this.filmId);
            return;
        }

        this.loadFilmData();
        this.renderCalendar();

        // Initialize Swiper after DOM update
        this.$nextTick(() => {
            this.initSwiper();
        });
    },
    beforeDestroy() {
        // Cleanup Swiper instance when component is destroyed
        if (this.swiper) {
            this.swiper.destroy();
        }
    },
    methods: {
        initSwiper() {
            this.swiper = new Swiper(".cart-wrapper3", {
                modules: [Navigation, Pagination],
                loop: true,
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                    dynamicBullets: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                scrollbar: {
                    el: ".swiper-scrollbar",
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                    },
                },
            });
        },

        async loadFilmData() {
            try {
                const filmIdInt = parseInt(this.filmId, 10);
                if (isNaN(filmIdInt) || filmIdInt <= 0) {
                    this.hasError = true;
                    this.errorMessage =
                        "ID phim không hợp lệ. Vui lòng chọn phim khác.";
                    return;
                }

                const response = await bookingTicketService.getStep1(filmIdInt);
                if (response.data) {
                    this.film = response.data.film;
                    this.showtimes =
                        response.data.showtimes === "empty"
                            ? []
                            : response.data.showtimes;
                    this.theaters = response.data.theaters || [];
                    this.isEmpty = response.data.showtimes === "empty";
                } else {
                    console.error("Invalid response format:", response);
                    this.hasError = true;
                    this.errorMessage =
                        "Không thể tải thông tin phim. Vui lòng thử lại sau.";
                }
            } catch (error) {
                console.error("Error loading film data:", error);
                this.hasError = true;
                this.errorMessage =
                    "Đã xảy ra lỗi khi tải thông tin phim. Vui lòng thử lại sau.";
            }
        },
        async selectDate(date) {
            if (!date) return;

            try {
                this.selectedDate = date;
                // Format date as YYYY-MM-DD for API
                const formattedDate = this.formatDateForApi(date);

                // Update active day in calendar
                this.calendarDays = this.calendarDays.map((day) => {
                    if (day.date && day.date.getTime() === date.getTime()) {
                        return { ...day, active: true };
                    }
                    return { ...day, active: false };
                });

                const response = await bookingTicketService.getShowtimesByDate({
                    date: formattedDate,
                    film_id: this.filmId,
                });

                if (response.data) {
                    this.showtimes = response.data.showtime || [];
                    this.theaters = response.data.theater || [];
                    this.isEmpty = this.showtimes.length === 0;
                }
            } catch (error) {
                console.error("Error fetching showtimes:", error);
                this.isEmpty = true;
            }
        },

        formatDateForApi(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, "0");
            const day = String(date.getDate()).padStart(2, "0");
            return `${year}-${month}-${day}`;
        },

        getShowtimesByTheater(theaterId) {
            if (!this.showtimes || !Array.isArray(this.showtimes)) return [];
            return this.showtimes.filter(
                (showtime) => showtime.theater_id === theaterId
            );
        },

        formatDate(dateString) {
            if (!dateString) return "";
            const date = new Date(dateString);
            return `${date.getDate()}/${
                date.getMonth() + 1
            }/${date.getFullYear()}`;
        },

        formatTime(timeString) {
            if (!timeString) return "";
            return timeString.substring(11, 16);
        },

        goToStep2(theaterId, showtimeId, filmId) {
            // Navigate to step2 with required parameters
            this.$router.push({
                name: "Step2",
                query: {
                    theater_id: theaterId,
                    showtime_id: showtimeId,
                    film_id: filmId,
                },
            });
        },

        renderCalendar() {
            const year = this.currentDate.getFullYear();
            const month = this.currentDate.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const today = new Date();

            this.calendarDays = [];

            // Empty cells before first day (adjust for Monday start)
            const firstDayAdjusted = firstDay === 0 ? 6 : firstDay - 1;
            for (let i = 0; i < firstDayAdjusted; i++) {
                this.calendarDays.push({ visible: false });
            }

            // Days of month
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                const isToday =
                    today.getDate() === day &&
                    today.getMonth() === month &&
                    today.getFullYear() === year;

                this.calendarDays.push({
                    day: day,
                    date: date,
                    visible: true,
                    isToday: isToday,
                    active: isToday, // Mark today as active by default
                });

                // If this is today, make it the selected date
                if (isToday) {
                    this.selectedDate = date;
                }
            }
        },

        prevMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() - 1);
            this.renderCalendar();
        },

        nextMonth() {
            this.currentDate.setMonth(this.currentDate.getMonth() + 1);
            this.renderCalendar();
        },
    },
};
</script>

<style scoped>
.calendar {
    padding: 20px;
}
.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    text-align: center;
    font-weight: bold;
    margin-bottom: 10px;
}
.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
}
.calendar-grid div {
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border-radius: 50%;
}
.active-day {
    background-color: #72be43;
    color: white;
}
.current-day {
    border: 1px solid #72be43;
}
.session-item {
    background-color: #72be43;
    border-radius: 5px;
    padding: 5px;
    margin-bottom: 10px;
    cursor: pointer;
}
.time a {
    display: block;
    padding: 5px;
}
.meta {
    font-size: 12px;
    color: white;
}
.meta span {
    margin-right: 5px;
}
.meta-title {
    font-weight: bold;
    margin-right: 5px;
}
.card-image {
    width: 100%;
    height: auto;
    border-radius: 10px;
}
</style>
