<template>
  <form class="mt-5 mb-5" @submit.prevent="handleRegister">
    <h3 class="fs-3 fw-bold">Đăng ký tài khoản</h3>
    <div class="d-flex row" style="margin-left: 2%; margin-right: 20%;">
      <div class="form-left col-6">
        <label class="form-label mt-4">Họ*</label>
        <input
          type="text"
          class="p-2 form-control input-group"
          v-model="firstName"
          required
        />

        <label class="form-label mt-4">Giới tính*</label>
        <select class="form-select p-2" v-model="gender" required>
          <option value="">Chọn giới tính</option>
          <option value="1">Nam</option>
          <option value="2">Nữ</option>
          <option value="3">Khác</option>
        </select>

        <label for="password" class="form-label mt-4">Mật khẩu*</label>
        <div class="input-group">
          <input
            :type="showPassword ? 'text' : 'password'"
            class="form-control p-2 password-input"
            v-model="password"
            required
          />
          <span class="input-group-text" @click="togglePassword">
            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
          </span>
        </div>
      </div>
      <div class="form-right col-6">
        <label class="form-label mt-4">Tên đệm và tên*</label>
        <input
          type="text"
          class="p-2 form-control input-group"
          v-model="lastName"
          required
        />

        <label for="email" class="form-label mt-4">Địa chỉ email*</label>
        <input
          type="email"
          class="p-2 form-control input-group"
          v-model="email"
          required
        />

        <label for="confirmPassword" class="form-label mt-4">Nhập lại mật khẩu*</label>
        <div class="input-group">
          <input
            :type="showConfirmPassword ? 'text' : 'password'"
            class="form-control p-2 password-input"
            v-model="confirmPassword"
            required
          />
          <span class="input-group-text" @click="toggleConfirmPassword">
            <i :class="showConfirmPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
          </span>
        </div>
      </div>

      <label for="phone" class="form-label mt-4">Số điện thoại*</label>
      <input
        type="text"
        class="form-control input-group"
        v-model="phone"
        required
      />

      <label for="date" class="form-label mt-4">Ngày sinh*</label>
      <input
        type="date"
        class="form-control w-25 input-group"
        v-model="birthDate"
        required
      />

      <label for="city" class="form-label mt-4">Tỉnh/Thành phố*</label>
      <select class="form-select p-2" v-model="city" required>
        <option value="">Chọn Tỉnh/Thành phố</option>
        <option value="Hồ Chí Minh">Hồ Chí Minh</option>
        <option value="Hà Nội">Hà Nội</option>
        <option value="Đà Nẵng">Đà Nẵng</option>
        <!-- Add more options as needed -->
      </select>

      <div class="d-flex mt-4">
        <input
          type="checkbox"
          class="form-check-input me-2"
          id="check"
          v-model="agreeTerms"
          required
        />
        <label class="form-check-label" for="check"
          >Tôi đồng ý với các điều khoản và điều kiện của BHD Star</label
        >
      </div>

      <button
        type="submit"
        class="btn btn-primary w-100 mt-4 button-radius border-0"
        style="background-color: #72be43;"
      >
        ĐĂNG KÝ
      </button>
    </div>
  </form>
</template>

<script>
import axios from '../../axious/axious'; // Import Axios instance

export default {
  name: 'RegisterForm',
  data() {
    return {
      firstName: '',
      lastName: '',
      gender: '',
      email: '',
      password: '',
      confirmPassword: '',
      phone: '',
      birthDate: '',
      city: '',
      agreeTerms: false,
      showPassword: false,
      showConfirmPassword: false,
    };
  },
  methods: {
    togglePassword() {
      this.showPassword = !this.showPassword;
    },
    toggleConfirmPassword() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },
    async handleRegister() {
      // Kiểm tra mật khẩu và xác nhận mật khẩu
      if (this.password !== this.confirmPassword) {
        alert('Mật khẩu và xác nhận mật khẩu không khớp!');
        return;
      }

      try {
        // Gửi yêu cầu đăng ký đến API
        const response = await axios.post('/register', {
          surname: this.firstName,
          name: this.lastName,
          gender: this.gender,
          email: this.email,
          password: this.password,
          phone: this.phone,
          date_of_birth: this.birthDate,
          province: this.city,
        });

        // Xử lý phản hồi từ API
        console.log('Đăng ký thành công:', response.data);
        alert('Đăng ký thành công!');
        localStorage.setItem('token', response.data.token); // Lưu token vào localStorage

        // Chuyển hướng người dùng sau khi đăng ký thành công
        window.location.href = '/dashboard'; // Thay đổi URL theo nhu cầu
      } catch (error) {
        // Xử lý lỗi từ API
        if (error.response) {
          console.error('Lỗi từ API:', error.response.data);
          alert(error.response.data.message || 'Đăng ký thất bại!');
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