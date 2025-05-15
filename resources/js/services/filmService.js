import axiosInstance from '../axious/axious';

const FilmService = {
    // Lấy danh sách phim
    getAll() {
        return axiosInstance.get('/admin/film/index');
    },

    // Thêm phim mới
    create(data) {
        return axiosInstance.post('/admin/film/create', data, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    },

    // Cập nhật phim
    update(data) {
        return axiosInstance.put('/admin/film/update', data, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });
    },

    // Xóa phim
    delete(id) {
        return axiosInstance.request({
            method: 'DELETE',
            url: '/admin/film/delete',
            data: { id },
        });
    }
};

export default FilmService;