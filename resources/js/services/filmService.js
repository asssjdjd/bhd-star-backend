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
    // update(data) {
    //     return axiosInstance.put('/admin/film/update', data, {
    //         headers: { 'Content-Type': 'multipart/form-data' }
    //     });
    // },

    update(data) {
    // Thêm _method=PUT để giả lập PUT request
        data.append('_method', 'PUT');
        return axiosInstance.post('/admin/film/update', data, {
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
    },

    getById(id) {
        return axiosInstance.get(`/admin/film/${id}`);
    },


    // API Showtime
    getShowtimes(filmId) {
        return axiosInstance.get(`/admin/showtime/index/${filmId}`);
    },

    createShowtime(filmId, data) {
        return axiosInstance.post(`/admin/showtime/create/${filmId}`, data);
    },

    updateShowtime(data) {
        return axiosInstance.put('/admin/showtime/update', data);
    },

    deleteShowtime(id) {
        return axiosInstance.request({
            method: 'DELETE',
            url: '/admin/showtime/delete',
            data: { id },
        });
    }

};

export default FilmService;