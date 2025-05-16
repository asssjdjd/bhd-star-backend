import axiosInstance from '../axious/axious2';

const foodComboService = {
    // Lấy danh sách combo đồ ăn
    getAll() {
        return axiosInstance.get('/admin/food-combo/index');
    },

    // Lấy danh sách combo đồ ăn theo id
    getById(id) {
        return axiosInstance.get(`/admin/food-combo/${id}`);
    },

    // Thêm combo đồ ăn mới
    create(data) {
        return axiosInstance.post('/admin/food-combo/create', data);
    },

    // Cập nhật combo đồ ăn
    update( data) {
        return axiosInstance.put(`/admin/food-combo/update`, data);
    },

    // Xóa combo đồ ăn
    delete(id) {
        return axiosInstance.request({
          method: 'DELETE',
          url: '/admin/food-combo/delete',
          data: { id },
        });
      },
};

export default foodComboService;