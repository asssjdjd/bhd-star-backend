<template>
    <div>
        <!-- Nút kiểm tra Alert -->

        <h1 class="ms-5 text-success">Danh sách danh mục</h1>
        <div class="float-end me-3">
            <a
                href="/admin/create-category"
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
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories" :key="category.id">
                    <th scope="row">{{ category.id }}</th>
                    <td>{{ category.type }}</td>
                    <td>
                        <button
                            class="btn btn-danger"
                            @click="confirmDelete(category.id)"
                        >
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
import categoryService from "../../services/categoryService";

export default defineComponent({
    name: "CategoryComponent",
    data() {
        return {
            categories: [], // Danh sách danh mục
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
        async fetchCategories() {
            try {
                const res = await categoryService.getAll();
                if (res.data.status === 200) {
                    this.categories = res.data.categories.data; // Laravel paginate trả về trong `data`
                } else {
                    alert(res.data.message);
                }
            } catch (err) {
                console.error("Fetch Categories Error:", err);
                alert("Không thể tải danh mục");
            }
        },

        // Hiển thị cảnh báo trước khi xóa
        confirmDelete(id) {
            if (confirm("Bạn có chắc chắn muốn xóa danh mục này?")) {
                this.deleteCategory(id);
            }
        },

        // Xóa danh mục
        async deleteCategory(id) {
            try {
                const res = await categoryService.delete(id); // Gửi `id` qua body
                if (res.status === 200) {
                    alert(res.data.message); // Hiển thị thông báo thành công
                    this.fetchCategories(); // Cập nhật danh sách sau khi xóa
                } else {
                    alert("Không thể xóa danh mục: " + res.data.message);
                }
            } catch (err) {
                console.error("Delete Category Error:", err);
                alert("Không thể xóa danh mục. Vui lòng thử lại.");
            }
        },
    },
    mounted() {
        this.fetchCategories(); // Gọi API khi component được mount
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
