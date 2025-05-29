import axiosInstance from "../axious/axious2";

const promotionService = {
    // Lấy danh sách khuyến mãi
    getAll() {
        return axiosInstance.get("/admin/promotion/index");
    },

    // Lấy thông tin chi tiết khuyến mãi
    getById(id) {
        return axiosInstance.get(`admin/promotion/${id}`);
    },

    // Thêm khuyến mãi mới
    create(data) {
        return axiosInstance.post("/admin/promotion/create", data);
    },

    // Cập nhật khuyến mãi
    update(data) {
        return axiosInstance.put(`/admin/promotion/update`, data);
    },

    // Xóa khuyến mãi
    delete(id) {
        return axiosInstance.request({
            method: "DELETE",
            url: "/admin/promotion/delete",
            data: { id },
        });
    },
};

export default promotionService;
