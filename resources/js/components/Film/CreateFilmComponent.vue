<!-- filepath: c:\xampp\htdocs\ttcs_ky2_nam3\bhd-star-backend\resources\js\components\Film\CreateFilmComponent.vue -->
<template>
  <div>
    <form @submit.prevent="submitForm" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Tên phim</label>
        <input type="text" v-model="film.name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Link video</label>
        <input type="text" v-model="film.video_link" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Thời lượng (phút)</label>
        <input type="number" v-model="film.duration" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tên đạo diễn</label>
        <input type="text" v-model="film.name_director" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Tên các diễn viên chính</label>
        <input type="text" v-model="film.name_actor" class="form-control" required>
      </div>
      <div class="mb-3 d-flex">
        <label class="form-label">Mô tả của phim</label>
        <textarea v-model="film.description" cols="100" rows="10" class="form-control"></textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Ngày khởi chiếu</label>
        <input type="date" v-model="film.launch_date" class="form-control w-25" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Thể loại của phim</label>
        <select v-model="film.type" class="form-select w-25">
          <option v-for="cat in categories" :key="cat.id" :value="cat.id">{{ cat.type }}</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Ảnh phim</label>
        <input type="file" @change="onFileChange" class="form-control">
      </div>
      <button type="submit" class="btn btn-primary">Thêm mới</button>
    </form>
  </div>
</template>

<script>
import FilmService from '../../services/filmService'
import categoryService from '../../services/categoryService'

export default {
  data() {
    return {
      film: {
        name: '',
        video_link: '',
        duration: '',
        name_director: '',
        name_actor: '',
        description: '',
        launch_date: '',
        type: '',
      },
      categories: [],
      imageFile: null,
    }
  },
  methods: {
    async fetchCategories() {
      try {
        const catRes = await categoryService.getAll();
        this.categories = catRes.data.categories.data || [];

        // console.log(catRes.data.categories.data);

      } catch (err) {
        alert('Không thể tải danh sách thể loại!');
        console.error(err);
      }
    },
    onFileChange(e) {
      this.imageFile = e.target.files[0];
    },
    async submitForm() {
      try {
        // console.log(this.film);
        // console.log(this.imageFile);
        const formData = new FormData();
        for (const key in this.film) {
          if (key === 'type') {
            formData.append(key, String(this.film[key]));
          } else {
            formData.append(key, this.film[key]);
          }
        }
        if (this.imageFile) {
          formData.append('images', this.imageFile);
        }
        // Gửi lên API thêm mới

        for (let pair of formData.entries()) {
          console.log(pair[0]+ ': ' + pair[1]);
        }
        
        const res = await FilmService.create(formData);
        alert(res.data.message || 'Thêm phim thành công!');
        // Reset form nếu muốn
        this.film = {
          name: '',
          video_link: '',
          duration: '',
          name_director: '',
          name_actor: '',
          description: '',
          launch_date: '',
          type: '',
        };
        this.imageFile = null;
        window.location.href = '/admin/film';
      } catch (err) {   
        alert('Có lỗi xảy ra khi thêm phim!');
        console.error(err);
      }
    }
  },
  mounted() {
    this.fetchCategories();
  }
}
</script>
