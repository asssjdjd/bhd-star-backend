<template>
  <form class="mt-5 mb-5" style="margin-left: 30%;" @submit.prevent="handleLogin">
    <h3 class="fs-3 fw-bold">Đăng nhập tài khoản</h3>

    <label for="email" class="form-label mt-4">Email*</label>
    <input
      type="email"
      class="p-2 form-control input-group"
      id="email"
      placeholder="Tài khoản hoặc Email của bạn"
      v-model="email"
      required
    />

    <label for="password" class="form-label mt-4">Mật khẩu*</label>
    <div class="input-group">
      <input
        :type="showPassword ? 'text' : 'password'"
        placeholder="Mật khẩu"
        class="form-control p-2 password-input"
        v-model="password"
        required
      />
      <span class="input-group-text" @click="togglePassword">
        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
      </span>
    </div>

    <div class="d-flex justify-content-end mt-3">
      <a href="#" class="text-decoration-none" style="color: #72be43">Quên mật khẩu?</a>
    </div>
    <button
      type="submit"
      class="btn btn-primary w-100 mt-4 button-radius border-0"
      style="background-color: #72be43;"
    >
      ĐĂNG NHẬP
    </button>
  </form>
</template>

<script>
import axios from '../../axious/axious'; // Import Axios instance

export default {
  name: 'LoginForm',
  data() {
    return {
      email: '',
      password: '',
      showPassword: false,
    };
  },
  methods: {
    togglePassword() {
      this.showPassword = !this.showPassword;
    },
    async handleLogin() {
      try {
        console.log('Đang gửi yêu cầu đăng nhập với thông tin:', {
          email: this.email,
          password: this.password,
        });

        // Gửi yêu cầu đăng nhập đến API
        const response = await axios.post('/login', {
          email: this.email,
          password: this.password,
        });

        // Debug kết quả trả về từ API
        console.log('Đăng nhập thành công:', response.data);

        // Lưu token vào localStorage
        localStorage.setItem('token', response.data.token);

        if (response.data.is_admin) {
      // Chuyển hướng đến trang admin
          window.location.href = 'http://127.0.0.1:8000/admin';
        } else {
          // Chuyển hướng đến trang người dùng
          window.location.href = 'http://127.0.0.1:8000/';
        }
      } catch (error) {
        // Debug lỗi nếu API trả về lỗi
        if (error.response) {
          console.error('Lỗi từ API:', error.response.data);
          alert(error.response.data.message || 'Đăng nhập thất bại!');
        } else {
          console.error('Lỗi không xác định:', error);
          alert('Đã xảy ra lỗi, vui lòng thử lại sau!');
        }
      }
    },
  },
};
</script>

<style scoped>
/* Add component-specific styles here if needed */
</style>