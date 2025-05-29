<template>
    <div>
        <h1 class="text-success">Thêm Mới Combo Đồ Ăn</h1>
        <form @submit.prevent="createFoodCombo">
            <div class="mb-3">
                <label class="form-label">Tên đồ ăn</label>
                <input type="text" v-model="foodCombo.name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" v-model="foodCombo.price" class="form-control" required>
            </div>
            <div class="mb-3 d-flex">
                <label class="form-label">Mô tả</label>
                <textarea v-model="foodCombo.description" cols="100" rows="10">
                </textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tải ảnh lên</label>
                <input type="file" @change="handleImageUpload" accept="image/*" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Chọn rạp</label>
                <select class="form-select w-25" v-model="foodCombo.theater_id">
                    <option v-for="theater in theaters" :key="theater.id" :value="theater.id">{{ theater.name }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Thêm đồ ăn</button>
        </form>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import foodComboService from "../../services/foodComboService";
import theaterService from "../../services/theaterService";

export default defineComponent({
    name: "CreateFoodComboComponent",
    data() {
        return {
            foodCombo: {
                name: "",
                price: "",
                description: "",
                theater_id: "",
            },
            imageFile: null,
            theaters: [], // Danh sách rạp
        };
    },
    methods: {
        // Xử lý khi người dùng chọn file
        handleImageUpload(event) {
            this.imageFile = event.target.files[0];
            // Có thể thêm logic xem trước ảnh ở đây nếu cần
        },

        // Tạo mới combo đồ ăn
        async createFoodCombo() {
            try {
                // Tạo FormData để gửi dữ liệu multipart bao gồm file
                const formData = new FormData();
                formData.append('name', this.foodCombo.name);
                formData.append('price', this.foodCombo.price);
                formData.append('description', this.foodCombo.description);
                formData.append('theater_id', this.foodCombo.theater_id);

                // Thêm file ảnh nếu đã chọn
                if (this.imageFile) {
                    formData.append('image', this.imageFile);
                }

                // Gửi request lên server
                const res = await foodComboService.create(formData);

                if (res.status === 200) {
                    window.location.href = '/admin/foodcombo';
                } else {
                    alert("Không thể thêm combo đồ ăn: ");
                }
            } catch (err) {
                console.error("Create FoodCombo Error:", err);
                alert("Không thể thêm combo đồ ăn. Vui lòng thử lại.");
            }
        },

        // Reset form sau khi thêm thành công
        resetForm() {
            this.foodCombo = {
                name: "",
                price: "",
                description: "",
                theater_id: "",
            };
            this.imageFile = null;
        },

        // Lấy danh sách rạp
        async fetchTheaters() {
            try {
                const res = await theaterService.getAll();
                if (res && res.data && res.data.theaters) {
                    this.theaters = res.data.theaters;
                } else {
                    const message = res && res.data ? res.data.message : "Không nhận được dữ liệu hợp lệ";
                    alert("Không thể tải danh sách rạp: " + message);
                }
            } catch (err) {
                console.error("Fetch Theaters Error:", err);
                alert("Không thể tải danh sách rạp. Vui lòng thử lại.");
            }
        },
    },
    mounted() {
        this.fetchTheaters();
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
