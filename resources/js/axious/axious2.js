import axios from 'axios';

// Tạo một instance của Axios
const axiosInstance = axios.create({
    baseURL: '/api', // Đặt base URL cho các API
    headers: {
        'Accept': 'application/json',
    },
});

// Thêm interceptor để tự động thêm token vào header Authorization
// và tự động xác định Content-Type dựa trên dữ liệu gửi đi
axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem('token'); // Lấy token từ localStorage
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    // Nếu dữ liệu là FormData, không đặt Content-Type để browser tự xác định
    // (browser sẽ tự động thêm boundary cần thiết)
    if (config.data instanceof FormData) {
        // Xóa header Content-Type để browser tự đặt multipart/form-data với boundary
        delete config.headers['Content-Type'];
    } else {
        // Nếu không phải FormData, sử dụng application/json
        config.headers['Content-Type'] = 'application/json';
    }

    return config;
}, error => {
    return Promise.reject(error);
});

// Xử lý lỗi từ phản hồi - giữ nguyên phần này
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