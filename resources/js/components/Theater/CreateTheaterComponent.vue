<template>
    <div>
        <h1 class="text-success">Thêm Mới Rạp Phim</h1>
        <form @submit.prevent="createTheater">
            <div class="mb-3">
                <label class="form-label">Tên rạp</label>
                <input
                    type="text"
                    v-model="theater.name"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Địa chỉ</label>
                <input
                    type="text"
                    v-model="theater.address"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Số điện thoại</label>
                <input
                    type="text"
                    v-model="theater.phone"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input
                    type="text"
                    v-model="theater.email"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3 d-flex">
                <label class="form-label">Quy định giá vé</label>
                <textarea v-model="theater.policy" cols="100" rows="10">
                </textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tải ảnh lên</label>
                <input
                    type="file"
                    @change="handleImageUpload"
                    accept="image/*"
                    class="form-control"
                    required
                />
            </div>

            <button type="submit" class="btn btn-primary">Thêm rạp phim</button>
        </form>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import theaterService from "../../services/theaterService";

export default defineComponent({
    name: "CreateTheaterComponent",
    data() {
        return {
            theater: {
                name: "",
                address: "",
                phone: "",
                email: "",
                policy: "",
            },
            imageFile: null,
        };
    },
    methods: {
        // Xử lý khi người dùng chọn file
        handleImageUpload(event) {
            this.imageFile = event.target.files[0];
            // Có thể thêm logic xem trước ảnh ở đây nếu cần
        },

        // Tạo mới rạp phim
        async createTheater() {
            try {
                // Tạo FormData để gửi dữ liệu multipart bao gồm file
                const formData = new FormData();
                formData.append("name", this.theater.name);
                formData.append("address", this.theater.address);
                formData.append("phone", this.theater.phone);
                formData.append("email", this.theater.email);
                formData.append("policy", this.theater.policy);

                // Thêm file ảnh nếu đã chọn
                if (this.imageFile) {
                    formData.append("image", this.imageFile);
                }

                // Gửi request lên server
                const res = await theaterService.create(formData);

                if (res.status === 201) {
                    window.location.href = "/admin/theater";
                } else {
                    alert("Không thể thêm rạp phim: ");
                }
            } catch (err) {
                console.error("Create Theater Error:", err);
                alert("Không thể thêm rạp phim. Vui lòng thử lại.");
            }
        },

        // Reset form sau khi thêm thành công
        resetForm() {
            this.theater = {
                name: "",
                price: "",
                description: "",
                theater_id: "",
            };
            this.imageFile = null;
        },
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
