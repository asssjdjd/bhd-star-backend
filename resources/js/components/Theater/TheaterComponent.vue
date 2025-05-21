<template>
    <div>
        <!-- Nút kiểm tra Alert -->

        <h1 class="ms-5 text-success">Danh sách rạp phim</h1>
        <div class="float-end me-3">
            <a
                href="/admin/theater/create"
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
                    <th scope="col">Address</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="theater in theaters" :key="theater.id">
                    <th scope="row">{{ theater.id }}</th>
                    <td>{{ theater.name }}</td>
                    <td style="font-size: 13px; max-width: 400px;">{{ theater.address }}</td>
                    <td>{{ theater.phone }}</td>
                    <td>{{ theater.email }}</td>
                    <td>
                        <button
                            class="btn btn-primary me-2"
                            @click="goToEdit(theater.id)"
                        >
                            Sửa
                        </button>
                        <button
                            class="btn btn-danger"
                            @click="confirmDelete(theater.id)"
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
import theaterService from "../../services/theaterService";

export default defineComponent({
    name: "TheaterComponent",
    data() {
        return {
            theaters: [], // Danh sách rạp
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

        // Lấy danh sách rạp phim
        async fetchTheater() {
            try {
                const res = await theaterService.getAll();
                console.log(res);
                if (res.data.status === 200) {
                    this.theaters = res.data.theaters;
                } else {
                    alert(res.data.message);
                }
            } catch (err) {
                console.error("Fetch Theater Error:", err);
                alert("Không thể tải rạp phim");
            }
        },

        // Hiển thị cảnh báo trước khi xóa
        confirmDelete(id) {
            if (confirm("Bạn có chắc chắn muốn xóa rạp phim này?")) {
                this.deleteTheater(id);
            }
        },

        // Xóa rạp phim
        async deleteTheater(id) {
            try {
                const res = await theaterService.delete(id); // Gửi `id` qua body
                if (res.status === 200) {
                    alert(res.data.message); // Hiển thị thông báo thành công
                    this.fetchTheater(); // Cập nhật danh sách sau khi xóa
                } else {
                    alert("Không thể xóa rạp phim: " + res.data.message);
                }
            } catch (err) {
                console.error("Delete Theater Error:", err);
                alert("Không thể xóa rạp phim. Vui lòng thử lại.");
            }
        },
        // Chuyển đến trang chỉnh sửa
        goToEdit(id) {
            window.location.href = `/admin/theater/${id}`;
        },
    },
    mounted() {
        this.fetchTheater(); // Gọi API khi component được mount
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
