import axios from 'axios';

// Tạo một instance của Axios
const axiosInstance = axios.create({
    baseURL: '/api', // Đặt base URL cho các API (Laravel tự động thêm tiền tố /api)
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true,
});

// Thêm interceptor để tự động thêm token vào header Authorization
axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem('token'); // Lấy token từ localStorage
    const theaterId = localStorage.getItem('theater_id');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    if (theaterId) {
        config.headers.theater_id = theaterId;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

// Xử lý lỗi từ phản hồi
axiosInstance.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response && error.response.status === 401) {
        console.error('Unauthorized! Redirecting to login...');
        // Xử lý khi token hết hạn hoặc không hợp lệ
        localStorage.removeItem('token'); // Xóa token
        window.location.href = '/login'; // Chuyển hướng đến trang đăng nhập
    }
    return Promise.reject(error);
});

export default axiosInstance;
