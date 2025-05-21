<template>
  <div>
    <!-- Header với nút thêm mới -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>Lịch chiếu phim: {{ filmName }}</h3>
      <button class="btn btn-primary" @click="openCreateModal">Thêm mới</button>
    </div>

    <!-- Bảng danh sách suất chiếu -->
    <div v-if="loading" class="text-center">
      <p>Đang tải dữ liệu...</p>
    </div>
    <div v-else>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Tên phim</th>
            <th scope="col">Rạp chiếu</th>
            <th scope="col">Thời gian chiếu</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Thao tác</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="showtime in showtimes" :key="showtime.id">
            <th scope="row">{{ showtime.id }}</th>
            <td>{{ filmName }}</td>
            <td>{{ showtime.theater_name }}</td>
            <td>{{ formatDateTime(showtime.start_time) }}</td>
            <td>{{ formatDateTime(showtime.created_at) }}</td>
            <td>
              <button class="btn btn-primary me-2" @click="openEditModal(showtime)">Sửa</button>
              <button class="btn btn-danger" @click="confirmDelete(showtime.id)">Xóa</button>
            </td>
          </tr>
          <tr v-if="showtimes.length === 0">
            <td colspan="6" class="text-center">Không có suất chiếu nào</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal thêm/sửa -->
    <div class="modal fade" id="showtimeModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ isEditing ? 'Sửa suất chiếu' : 'Thêm suất chiếu mới' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="submitForm">
              <!-- Input trường thời gian chiếu -->
              <div class="mb-3">
                <label class="form-label">Thời gian chiếu</label>
                <input type="datetime-local" v-model="showtimeForm.start_time" class="form-control" required />
              </div>
              
              <!-- Select rạp chiếu -->
              <div class="mb-3">
                <label class="form-label">Rạp chiếu</label>
                <select v-model="showtimeForm.theater_id" class="form-select" required>
                  <option v-for="theater in theaters" :key="theater.id" :value="theater.id">
                    {{ theater.name }}
                  </option>
                </select>
              </div>

              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">{{ isEditing ? 'Cập nhật' : 'Thêm mới' }}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FilmService from '../../services/filmService';
import theaterService from '../../services/theaterService';
import { Modal } from 'bootstrap';

export default {
  props: {
    filmId: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      showtimes: [],
      theaters: [],
      filmName: '',
      showtimeForm: {
        id: null,
        film_id: null,
        start_time: '',
        theater_id: ''
      },
      isEditing: false,
      loading: true,
      modal: null,
       // Thêm biến để lưu ID tách từ URL
      filmIdFromUrl: null,
    };
  },

  // Thêm computed property để tính toán ID thực tế sẽ sử dụng
  computed: {
    actualFilmId() {
      return this.filmId || this.filmIdFromUrl;
    }
  },

  methods: { 
    async fetchShowtimes() {
      try {
        this.loading = true;
        // console.log('filmId:', this.filmId);
        // console.log('actualFilmId:', this.filmIdFromUrl);
        const response = await FilmService.getShowtimes(this.filmIdFromUrl);

        console.log('Showtimes:', response);

        this.showtimes = response.data.showtimes || [];
        this.filmName = response.data.film_name || '';

        // console.log('Film Name:', this.filmName);
        // // Lưu tên phim vào biến filmName
        // console.log('Showtimes:', this.showtimes);
        this.loading = false;
      } catch (err) {
        console.error('Error fetching showtimes:', err);
        alert('Không thể tải danh sách suất chiếu');
        this.loading = false;
      }
    },
    
    async fetchTheaters() {
      try {
        const response = await theaterService.getAll();

        console.log('Theaters:', response);

        this.theaters = response.data.theaters || [];


      } catch (err) {
        console.error('Error fetching theaters:', err);
        alert('Không thể tải danh sách rạp chiếu');
      }
    },
    
    openCreateModal() {
      this.isEditing = false;
      this.showtimeForm = {
        film_id: this.filmIdFromUrl,
        start_time: '',
        theater_id: ''
      };
      this.modal.show();
    },
    
    openEditModal(showtime) {
      this.isEditing = true;
      this.showtimeForm = {
        id: showtime.id,
        film_id: showtime.film_id,
        start_time: this.formatDateForInput(showtime.start_time),
        theater_id: showtime.theater_id
      };
      this.modal.show();
    },
    
    async submitForm() {
      try {
        if (this.isEditing) {
          // Cập nhật suất chiếu hiện có
          await FilmService.updateShowtime(this.showtimeForm);
          alert('Cập nhật suất chiếu thành công');
        } else {
          // Tạo suất chiếu mới
          console.log(this.filmIdFromUrl, this.showtimeForm);
      
          await FilmService.createShowtime(this.filmIdFromUrl, this.showtimeForm);
          alert('Thêm suất chiếu thành công');
        }
        this.modal.hide();
        this.fetchShowtimes(); // Tải lại danh sách
      } catch (err) {
        console.error('Error submitting form:', err);
        alert('Có lỗi xảy ra. Vui lòng thử lại');
      }
    },
    
    async confirmDelete(id) {
      if (confirm('Bạn có chắc chắn muốn xóa suất chiếu này?')) {
        try {
          await FilmService.deleteShowtime(id);
          alert('Xóa suất chiếu thành công');
          this.fetchShowtimes(); // Tải lại danh sách
        } catch (err) {
          console.error('Error deleting showtime:', err);
          alert('Không thể xóa suất chiếu');
        }
      }
    },
    
    formatDateTime(dateTime) {
      if (!dateTime) return '';
      const date = new Date(dateTime);
      return new Intl.DateTimeFormat('vi-VN', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      }).format(date);
    },
    
    formatDateForInput(dateTime) {
      if (!dateTime) return '';
      const date = new Date(dateTime);
      return date.toISOString().slice(0, 16); // Format: YYYY-MM-DDThh:mm
    }
  },
  mounted() {
    // Tạo instance của Modal Bootstrap
    this.modal = new Modal(document.getElementById('showtimeModal'));
    
    // Lấy filmId từ URL - sửa lại logic này
    const urlPath = window.location.pathname;
    const matches = urlPath.match(/\/admin\/showtime\/(\d+)$/);
    
    if (matches && matches[1]) {
      this.filmIdFromUrl = matches[1];
      console.log('Film ID từ URL:', this.filmIdFromUrl);
    } else {
      console.error('Không thể lấy Film ID từ URL:', urlPath);
    }
    
    if (!this.actualFilmId) {
      alert('Không tìm thấy ID phim. Vui lòng thử lại.');
      return;
    }
    
    // Tải dữ liệu ban đầu
    this.fetchTheaters();
    this.fetchShowtimes();
  }
};
</script>