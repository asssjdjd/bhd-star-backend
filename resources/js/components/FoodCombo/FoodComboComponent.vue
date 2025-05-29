<template>
    <div>
        <!-- Nút kiểm tra Alert -->

        <h1 class="ms-5 text-success">Danh sách combo đồ ăn</h1>
        <div class="float-end me-3">
            <a
                href="/admin/foodcombo/create"
                class="btn btn-primary text-decoration-none text-white"
            >
                Thêm mới
            </a>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Theater</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="foodcombo in foodcombos" :key="foodcombo.id">
                    <th scope="row">{{ foodcombo.id }}</th>
                    <td>{{ foodcombo.name }}</td>
                    <td>{{ foodcombo.price }}</td>
                    <td>{{ foodcombo.theater_name }}</td>
                    <td>
                        <button class="btn btn-primary me-2" @click="goToEdit(foodcombo.id)">Sửa</button>
                        <button class="btn btn-danger" @click="confirmDelete(foodcombo.id)">
                            Xóa
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import foodComboService from "../../services/foodComboService";

export default defineComponent({
    name: "FoodComboComponent",
    data() {
        return {
            foodcombos: [], // Danh sách danh mục
        };
    },
    methods: {
        // Hiển thị thông báo thành công
        showSuccess() {
            alert("Thành công!");
        },

        // Hiển thị thông báo lỗi
        showError() {
            alert("Đã xảy ra lỗi!");
        },

        // Lấy danh sách danh mục
        async fetchFoodCombo() {
            try {
                const res = await foodComboService.getAll();
                console.log(res);
                if (res.data.status === 200) {
                    this.foodcombos = res.data.foods;
                } else {
                    alert(res.data.message);
                }
            } catch (err) {
                console.error("Fetch FoodCombo Error:", err);
                alert("Không thể tải danh mục");
            }
        },

        // Hiển thị cảnh báo trước khi xóa
        confirmDelete(id) {
            if (confirm("Bạn có chắc chắn muốn xóa danh mục này?")) {
                this.deleteFoodCombo(id);
            }
        },

        // Xóa danh mục
        async deleteFoodCombo(id) {
            try {
                const res = await foodComboService.delete(id); // Gửi `id` qua body
                if (res.status === 200) {
                    alert(res.data.message); // Hiển thị thông báo thành công
                    this.fetchFoodCombo(); // Cập nhật danh sách sau khi xóa
                } else {
                    alert("Không thể xóa danh mục: " + res.data.message);
                }
            } catch (err) {
                console.error("Delete FoodCombo Error:", err);
                alert("Không thể xóa danh mục. Vui lòng thử lại.");
            }
        },
        // Chuyển đến trang chỉnh sửa
        goToEdit(id) {
            window.location.href = `/admin/foodcombo/${id}`;
        },
    },
    mounted() {
        this.fetchFoodCombo(); // Gọi API khi component được mount
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
