<template>
    <div>
        <h1 class="text-success">Chỉnh Sửa Rạp Phim</h1>
        <form @submit.prevent="updatePromotion" v-if="promotion">
            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input
                    type="text"
                    v-model="promotion.title"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Giá giảm</label>
                <input
                    type="text"
                    v-model="promotion.discount_value"
                    class="form-control"
                    required
                />
            </div>
            <div class="mb-3 d-flex">
                <label class="form-label">Mô tả</label>
                <textarea v-model="promotion.description" cols="100" rows="10">
                </textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Ngày hết hạn</label>
                <input
                    type="date"
                    v-model="promotion.discount"
                    class="form-control w-25"
                    required
                />
            </div>
            <div class="mb-3">
                <label class="form-label">Loại giảm giá</label>
                <select
                    class="form-select w-25"
                    v-model="discount_type"
                    required
                >
                    <option value="1" selected>Theo phần trăm</option>
                    <option value="2">Theo giá</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Thêm khuyến mãi
            </button>
        </form>
        <div v-else class="alert alert-warning">Đang tải dữ liệu...</div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import promotionService from "../../services/promotionService";

export default defineComponent({
    name: "EditPromotionComponent",
    data() {
        return {
            promotion: null, // Danh sách rạp
            loading: true,
            promotionId: null,
        };
    },
    methods: {
        // Lấy thông tin rạp phim hiện tại
        async fetchPromotion() {
            try {
                // Lấy ID từ URL (phụ thuộc vào cách cấu hình route)
                const urlParts = window.location.pathname.split("/");
                this.promotionId = urlParts[urlParts.length - 1]; // Giả sử URL có dạng /admin/promotion/edit/123

                const res = await promotionService.getById(this.promotionId);

                if (res && res.data && res.data.status === 200) {
                    this.promotion = res.data.promotion;
                } else {
                    alert("Không thể tải thông tin khuyễn mãi");
                }
                this.loading = false;
            } catch (err) {
                console.error("Fetch promotion Error:", err);
                alert("Không thể tải thông tin khuyễn mãi. Vui lòng thử lại.");
                this.loading = false;
            }
        },

        // Cập nhật khuyễn mãi
        async updatePromotion() {
            try {
                // Sử dụng JSON object thay vì FormData
                const updateData = {
                    id: parseInt(this.promotionId),
                    title: this.promotion.title,
                    discount_value: this.promotion.discount_value,
                    description: this.promotion.description,
                    discount: this.promotion.discount,
                    discount_type: this.promotion.discount_type,
                };

                console.log("Update data:", updateData);

                // Gửi request lên server
                const res = await promotionService.update(updateData);

                if (res.status === 200) {
                    alert("Cập nhật thành công!");
                    window.location.href = "/admin/promotion";
                } else {
                    alert(
                        "Không thể cập nhật khuyễn mãi: " +
                            (res.data.message || "")
                    );
                }
            } catch (err) {
                console.error("Update Promotion Error:", err);
                alert("Không thể cập nhật khuyễn mãi. Vui lòng thử lại.");
            }
        },

        // Lấy danh sách rạp
    },
    mounted() {
        // Gọi API khi component được mount
        this.fetchPromotion();
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
