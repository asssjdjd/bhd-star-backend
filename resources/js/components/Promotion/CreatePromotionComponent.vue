<template>
    <div>
        <h1 class="text-success">Thêm Mới khuyến mãi</h1>
        <form @submit.prevent="createPromotion">
            <div class="mb-3">
                <label class="form-label">Tiêu đề</label>
                <input type="text" v-model="promotion.title" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Giá giảm</label>
                <input type="text" v-model="promotion.discount_value" class="form-control" required>
            </div>
            <div class="mb-3 d-flex">
                <label class="form-label">Mô tả</label>
                <textarea v-model="promotion.description" cols="100" rows="10">
                </textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tải ảnh lên</label>
                <input type="file" @change="handleImageUpload" accept="image/*" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ngày hết hạn</label>
                <input type="date" v-model="promotion.discount" class="form-control w-25" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Loại giảm giá</label>
                <select class="form-select w-25" v-model="discount_type" required>
                    <option value="1" selected>Theo phần trăm</option>
                    <option value="2">Theo giá</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Thêm khuyến mãi</button>
        </form>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import promotionService from "../../services/promotionService";

export default defineComponent({
    name: "CreatePromotionComponent",
    data() {
        return {
            promotion: {
                title: "",
                discount_value: "",
                description: "",
                discount: "",
                discount_type: 1,
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

        // Tạo mới khuyến mãi
        async createPromotion() {
            try {
                // Tạo FormData để gửi dữ liệu multipart bao gồm file
                const formData = new FormData();
                formData.append('title', this.promotion.title);
                formData.append('discount_value', this.promotion.discount_value);
                formData.append('description', this.promotion.description);
                formData.append('discount', this.promotion.discount);
                formData.append('discount_type', this.promotion.discount_type);


                // Thêm file ảnh nếu đã chọn
                if (this.imageFile) {
                    formData.append('image', this.imageFile);
                }

                // Gửi request lên server
                const res = await promotionService.create(formData);

                if (res.status === 201) {
                    window.location.href = '/admin/promotion';
                } else {
                    alert("Không thể thêm khuyến mãi: ");
                }
            } catch (err) {
                console.error("Create Promotion Error:", err);
                alert("Không thể thêm khuyến mãi. Vui lòng thử lại.");
            }
        },

        // Reset form sau khi thêm thành công
        resetForm() {
            this.promotion = {
                title: "",
                discount_value: "",
                description: "",
                discount: "",
                discount_type: 1,
            };
            this.imageFile = null;
        },

    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
