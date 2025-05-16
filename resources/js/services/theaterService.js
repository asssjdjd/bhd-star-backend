import axiosInstance from '../axious/axious2';

const theaterService = {
    // Lấy tất cả rạp chiếu
    getAll() {
        return axiosInstance.get('/admin/theater/index');
    },

    // Lấy thông tin rạp chiếu theo ID
    getById(id) {
        return axiosInstance.get(`/admin/theater/${id}`);
    },

    // Thêm rạp mới
    create(data) {
        return axiosInstance.post('/admin/theater/create', data);
    },

    // Cập nhật rạp
    update( data) {
        return axiosInstance.put(`/admin/theater/update`, data);
    },

    // Xóa rạp
    delete(id) {
        return axiosInstance.request({
          method: 'DELETE',
          url: '/admin/theater/delete',
          data: { id },
        });
    },
    
};

export default theaterService;