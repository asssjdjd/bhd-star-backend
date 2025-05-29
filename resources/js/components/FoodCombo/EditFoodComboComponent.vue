<template>
    <div>
        <h1 class="text-success">Chỉnh Sửa Combo Đồ Ăn</h1>
        <form @submit.prevent="updateFoodCombo" v-if="foodCombo">
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
                <label class="form-label">Chọn rạp</label>
                <select class="form-select w-25" v-model="foodCombo.theater_id">
                    <option v-for="theater in theaters" :key="theater.id" :value="theater.id">{{ theater.name }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
        <div v-else class="alert alert-warning">
            Đang tải dữ liệu...
        </div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import foodComboService from "../../services/foodComboService";
import theaterService from "../../services/theaterService";

export default defineComponent({
    name: "EditFoodComboComponent",
    data() {
        return {
            foodCombo: null,
            theaters: [], // Danh sách rạp
            loading: true,
            foodId: null
        };
    },
    methods: {
        // Lấy thông tin food combo hiện tại
        async fetchFoodCombo() {
            try {
                // Lấy ID từ URL (phụ thuộc vào cách cấu hình route)
                const urlParts = window.location.pathname.split('/');
                this.foodId = urlParts[urlParts.length - 1]; // Giả sử URL có dạng /admin/foodcombo/edit/123

                const res = await foodComboService.getById(this.foodId);

                if (res && res.data && res.data.status === 200) {
                    this.foodCombo = res.data.food;
                } else {
                    alert("Không thể tải thông tin combo đồ ăn");
                }
                this.loading = false;
            } catch (err) {
                console.error("Fetch FoodCombo Error:", err);
                alert("Không thể tải thông tin combo đồ ăn. Vui lòng thử lại.");
                this.loading = false;
            }
        },

        // Cập nhật combo đồ ăn
        async updateFoodCombo() {
            try {
                // Sử dụng JSON object thay vì FormData
                const updateData = {
                    id: parseInt(this.foodId),
                    name: this.foodCombo.name,
                    price: parseInt(this.foodCombo.price),
                    description: this.foodCombo.description,
                    theater_id: parseInt(this.foodCombo.theater_id)
                };

                console.log("Update data:", updateData);

                // Gửi request lên server
                const res = await foodComboService.update(updateData);

                if (res.status === 200) {
                    alert("Cập nhật thành công!");
                    window.location.href = '/admin/foodcombo';
                } else {
                    alert("Không thể cập nhật combo đồ ăn: " + (res.data.message || ""));
                }
            } catch (err) {
                console.error("Update FoodCombo Error:", err);
                alert("Không thể cập nhật combo đồ ăn. Vui lòng thử lại.");
            }
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
        // Gọi API khi component được mount
        this.fetchFoodCombo();
        this.fetchTheaters();
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
