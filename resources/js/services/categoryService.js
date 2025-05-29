import axiosInstance from "../axious/axious2";

const categoryService = {
    // Lấy danh sách danh mục
    getAll() {
        return axiosInstance.get("/admin/category");
    },

    // Thêm danh mục mới
    create(data) {
        return axiosInstance.post("/admin/category/create", data); // Sửa URL
    },

    // Cập nhật danh mục
    update(id, data) {
        return axiosInstance.put(`/admin/category/${id}`, data);
    },

    // Xóa danh mục
    delete(id) {
        return axiosInstance.request({
            method: "DELETE",
            url: "/admin/category/delete",
            data: { id }, // Gửi `id` trong body
        });
    },
};

export default categoryService;
