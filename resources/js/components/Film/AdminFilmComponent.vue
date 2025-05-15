<!-- filepath: c:\xampp\htdocs\ttcs_ky2_nam3\bhd-star-backend\resources\js\components\AdminFilmComponent.vue -->
<template>
  <div id="film-list-app">
    <h1 class="text-success mt-3 ms-4 mb-3">Danh sách phim</h1>
    <div>
      <div class="float-end mb-3">
        <button class="btn btn-primary" @click="goToCreate">
          Thêm mới
        </button>
      </div>
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col" class="col">#</th>
            <th scope="col" class="col">Name</th>
            <th scope="col" class="col">Duration</th>
            <th scope="col" class="col">Type</th>
            <th scope="col" class="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="film in films" :key="film.id">
            <th scope="row">{{ film.id }}</th>
            <td>{{ film.name }}</td>
            <td>{{ film.duration }}</td>
            <td>{{ film.category_name || film.type || '' }}</td>
            <td>
              <button class="btn btn-info me-2" @click="goToShowTime(film.id)">Xem chi tiết</button>
              <button class="btn btn-primary me-2" @click="goToEdit(film.id)">Sửa</button>
              <button class="btn btn-danger" @click="confirmDelete(film.id)">Xóa</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import FilmService from '../../services/filmService';

export default {
  name: "AdminFilmComponent",
  data() {
    return {
      films: [],
    };
  },
  methods: {
    showSuccess(msg = "Thành công!") {
      alert(msg);
    },
    showError(msg = "Đã xảy ra lỗi!") {
      alert(msg);
    },
    async fetchFilms() {
      try {
        const res = await FilmService.getAll();
        this.films = res.data.films || res.data.response || [];
      } catch (err) {
        console.error("Fetch Films Error:", err);
        this.showError("Không thể tải danh sách phim");
      }
    },
    confirmDelete(id) {
      if (confirm("Bạn có chắc chắn muốn xóa phim này?")) {
        this.deleteFilm(id);
      }
    },
    async deleteFilm(id) {
      try {
        const res = await FilmService.delete(id);
        if (res.status === 200) {
          this.showSuccess(res.data.message || "Xóa thành công!");
          this.fetchFilms();
        } else {
          this.showError("Không thể xóa phim: " + res.data.message);
        }
      } catch (err) {
        console.error("Delete Film Error:", err);
        this.showError("Không thể xóa phim. Vui lòng thử lại.");
      }
    },
    goToCreate() {
      window.location.href = '/admin/create-film';
    },
    goToEdit(id) {
      window.location.href = `/admin/film/${id}`;
    },
    goToShowTime(id) {
      window.location.href = `/admin/showtime/${id}`;
    },
  },
  mounted() {
    this.fetchFilms();
  },
};
</script>