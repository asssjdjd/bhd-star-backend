<template>
    <div>
        <h1 class="text-success">Chỉnh Sửa Rạp Phim</h1>
        <form @submit.prevent="updatetheater" v-if="theater">
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

            <button type="submit" class="btn btn-primary">
                Cập nhật rạp phim
            </button>
        </form>
        <div v-else class="alert alert-warning">Đang tải dữ liệu...</div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import theaterService from "../../services/theaterService";

export default defineComponent({
    name: "EditTheaterComponent",
    data() {
        return {
            theater: null, // Danh sách rạp
            loading: true,
            theaterId: null,
        };
    },
    methods: {
        // Lấy thông tin rạp phim hiện tại
        async fetchTheater() {
            try {
                // Lấy ID từ URL (phụ thuộc vào cách cấu hình route)
                const urlParts = window.location.pathname.split("/");
                this.theaterId = urlParts[urlParts.length - 1]; // Giả sử URL có dạng /admin/theater/edit/123

                const res = await theaterService.getById(this.theaterId);

                if (res && res.data && res.data.status === 200) {
                    this.theater = res.data.theater;
                } else {
                    alert("Không thể tải thông tin combo đồ ăn");
                }
                this.loading = false;
            } catch (err) {
                console.error("Fetch theater Error:", err);
                alert("Không thể tải thông tin combo đồ ăn. Vui lòng thử lại.");
                this.loading = false;
            }
        },

        // Cập nhật combo đồ ăn
        async updatetheater() {
            try {
                // Sử dụng JSON object thay vì FormData
                const updateData = {
                    id: parseInt(this.theaterId),
                    name: this.theater.name,
                    address: this.theater.address,
                    phone: this.theater.phone,
                    email: this.theater.email,
                    policy: this.theater.policy,
                };

                console.log("Update data:", updateData);

                // Gửi request lên server
                const res = await theaterService.update(updateData);

                if (res.status === 200) {
                    alert("Cập nhật thành công!");
                    window.location.href = "/admin/theater";
                } else {
                    alert(
                        "Không thể cập nhật combo đồ ăn: " +
                            (res.data.message || "")
                    );
                }
            } catch (err) {
                console.error("Update theater Error:", err);
                alert("Không thể cập nhật combo đồ ăn. Vui lòng thử lại.");
            }
        },

        // Lấy danh sách rạp
    },
    mounted() {
        // Gọi API khi component được mount
        this.fetchTheater();
    },
});
</script>

<style>
/* Thêm style tùy chỉnh nếu cần */
</style>
