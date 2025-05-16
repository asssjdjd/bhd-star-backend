<template>
    <div>
        <h1 class="text-success">Thêm Mới Danh Mục</h1>
        <form @submit.prevent="createCategory">
            <div class="mb-3">
                <label for="type" class="form-label">Tên Danh Mục</label>
                <input
                    type="text"
                    id="type"
                    v-model="type"
                    class="form-control"
                    placeholder="Nhập tên danh mục"
                    required
                />
            </div>
            <button type="submit" class="btn btn-primary">Thêm Mới</button>
        </form>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import categoryService from "../../services/categoryService";

export default defineComponent({
    name: "CreateCategoryComponent",
    data() {
        return {
            type: "", // Tên danh mục
        };
    },
    methods: {
        async createCategory() {
            try {
                const res = await categoryService.create({ type: this.type });
                if (res.status === 201) {
                    alert(res.data.message); // Hiển thị thông báo thành công
                    window.location.href = "/admin/category"; // Chuyển hướng về danh sách danh mục
                    this.type = ""; // Reset form
                } else {
                    alert("Không thể thêm danh mục: " + res.data.message); // Hiển thị lỗi từ server
                }
            } catch (err) {
                console.error("Create Category Error:", err);
                alert("Không thể thêm danh mục. Vui lòng thử lại."); // Hiển thị lỗi chung
            }
        },
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
