<template>
    <div>
        <!-- Nút kiểm tra Alert -->

        <h1 class="ms-5 text-success">Danh sách khuyến mãi</h1>
        <div class="float-end me-3">
            <a
                href="/admin/promotion/create"
                class="btn btn-primary text-decoration-none text-white"
            >
                Thêm mới
            </a>
        </div>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="promotion in promotions" :key="promotion.id">
                    <th scope="row">{{ promotion.id }}</th>
                    <td>{{ promotion.title }}</td>
                    <td >{{ promotion.status }}</td>
                    <td>{{ promotion.discount }}</td>
                    <td style="font-size: 13px; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        {{ promotion.description }}
                    </td>
                    <td>
                        <button class="btn btn-primary me-2" @click="goToEdit(promotion.id)">Sửa</button>
                        <button class="btn btn-danger" @click="confirmDelete(promotion.id)">
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
import promotionService from "../../services/promotionService";

export default defineComponent({
    name: "promotionComponent",
    data() {
        return {
            promotions: [], // Danh sách rạp
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

        // Lấy danh sách khuyến mãi
        async fetchPromotion() {
            try {
                const res = await promotionService.getAll();
                console.log(res);
                if (res.data.status === 200) {
                    this.promotions = res.data.promotions;
                } else {
                    alert(res.data.message);
                }
            } catch (err) {
                console.error("Fetch promotion Error:", err);
                alert("Không thể tải khuyến mãi");
            }
        },

        // Hiển thị cảnh báo trước khi xóa
        confirmDelete(id) {
            if (confirm("Bạn có chắc chắn muốn xóa khuyến mãi này?")) {
                this.deletepromotion(id);
            }
        },

        // Xóa khuyến mãi
        async deletepromotion(id) {
            try {
                const res = await promotionService.delete(id); // Gửi `id` qua body
                if (res.status === 200) {
                    alert(res.data.message); // Hiển thị thông báo thành công
                    this.fetchPromotion(); // Cập nhật danh sách sau khi xóa
                } else {
                    alert("Không thể xóa khuyến mãi: " + res.data.message);
                }
            } catch (err) {
                console.error("Delete promotion Error:", err);
                alert("Không thể xóa khuyến mãi. Vui lòng thử lại.");
            }
        },
        // Chuyển đến trang chỉnh sửa
        goToEdit(id) {
            window.location.href = `/admin/promotion/${id}`;
        },
    },
    mounted() {
        this.fetchPromotion(); // Gọi API khi component được mount
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
