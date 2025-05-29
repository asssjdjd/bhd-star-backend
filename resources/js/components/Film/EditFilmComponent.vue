<template>
    <div>
        <div v-if="loading" class="text-center">
            <p>Đang tải...</p>
        </div>
        <form v-else @submit.prevent="submitForm" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Tên phim</label>
                <input
                    type="text"
                    v-model="film.name"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Link video</label>
                <input
                    type="text"
                    v-model="film.video_link"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Thời lượng (phút)</label>
                <input
                    type="number"
                    v-model="film.duration"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Tên đạo diễn</label>
                <input
                    type="text"
                    v-model="film.name_director"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Tên các diễn viên chính</label>
                <input
                    type="text"
                    v-model="film.name_actor"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3 d-flex">
                <label class="form-label">Mô tả của phim</label>
                <textarea
                    v-model="film.description"
                    cols="100"
                    rows="10"
                    class="form-control"
                ></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày khởi chiếu</label>
                <input
                    type="date"
                    v-model="film.launch_date"
                    class="form-control w-25"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Thể loại của phim</label>
                <select v-model="film.type" class="form-select w-25">
                    <option
                        v-for="cat in categories"
                        :key="cat.id"
                        :value="cat.id"
                    >
                        {{ cat.type }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Ảnh phim hiện tại</label>
                <div v-if="film.images">
                    <img
                        :src="film.images"
                        alt="Ảnh phim"
                        style="max-width: 200px; margin-bottom: 10px"
                    />
                </div>
                <label class="form-label"
                    >Thay đổi ảnh phim (Để trống nếu không thay đổi)</label
                >
                <input
                    type="file"
                    @change="onFileChange"
                    class="form-control"
                />
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật phim</button>
        </form>
    </div>
</template>

<script>
import FilmService from "../../services/filmService";
import categoryService from "../../services/categoryService";

export default {
    data() {
        return {
            film: {
                id: null,
                name: "",
                video_link: "",
                duration: "",
                name_director: "",
                name_actor: "",
                description: "",
                launch_date: "",
                type: "",
                images: "",
            },
            categories: [],
            imageFile: null,
            loading: true,
            filmId: null,
        };
    },
    methods: {
        async fetchCategories() {
            try {
                const catRes = await categoryService.getAll();
                this.categories = catRes.data.categories.data || [];
            } catch (err) {
                alert("Không thể tải danh sách thể loại!");
                console.error(err);
            }
        },
        async fetchFilmData() {
            try {
                const response = await FilmService.getById(this.filmId);
                const filmData = response.data.film;

                // Cập nhật dữ liệu film
                this.film = {
                    id: filmData.id,
                    name: filmData.name,
                    video_link: filmData.video_link,
                    duration: filmData.duration,
                    name_director: filmData.name_director,
                    name_actor: filmData.name_actor,
                    description: filmData.description,
                    launch_date: filmData.launch_date,
                    type: filmData.type,
                    images: filmData.images,
                };

                this.loading = false;
            } catch (err) {
                alert("Không thể tải thông tin phim!");
                console.error(err);
                this.loading = false;
            }
        },
        onFileChange(e) {
            this.imageFile = e.target.files[0];
        },

        async submitForm() {
            try {
                if (!this.film.id) {
                    alert("Không tìm thấy ID của phim!");
                    return;
                }

                const formData = new FormData();
                formData.append("id", this.film.id);

                // Thêm các trường khác vào form data
                for (const key in this.film) {
                    if (key !== "id") {
                        if (key === "type") {
                            formData.append(key, String(this.film[key]));
                        } else if (key === "images") {
                            // Không thêm URL ảnh cũ vào formData
                            // Backend sẽ giữ nguyên ảnh cũ nếu không có file mới
                        } else {
                            formData.append(key, this.film[key]);
                        }
                    }
                }

                // Chỉ thêm file ảnh mới nếu người dùng chọn
                if (this.imageFile) {
                    formData.append("images", this.imageFile);
                }

                const res = await FilmService.update(formData);
                alert(res.data.message || "Cập nhật phim thành công!");
                window.location.href = '/admin/film';
            } catch (err) {
                alert("Có lỗi xảy ra khi cập nhật phim!");
                console.error(err.response ? err.response.data : err);
            }
        },
    },
    mounted() {
        // Lấy ID từ URL (giả sử URL có dạng /admin/edit/1)
        const urlParts = window.location.pathname.split("/");
        this.filmId = urlParts[urlParts.length - 1];

        // Tải danh mục và dữ liệu phim
        this.fetchCategories().then(() => {
            this.fetchFilmData();
        });
    },
};
</script>
