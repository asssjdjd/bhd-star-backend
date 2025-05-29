<template>
  <div class="content">
    <div class="container1 d-flex flex-column gap-2">
      <h3 class="mb-3 text-primary">🔑 Đổi Mật Khẩu</h3>
      <form @submit.prevent="submitResetPassword">
        <div class="mb-3">
          <input
            type="password"
            v-model="password"
            class="form-control"
            placeholder="Mật khẩu mới"
            required
          />
        </div>
        <div class="mb-3">
          <input
            type="password"
            v-model="password_confirmation"
            class="form-control"
            placeholder="Xác nhận mật khẩu mới"
            required
          />
        </div>
        <button type="submit" class="btn btn-primary w-100" :disabled="loading">
          <span v-if="loading">Đang đổi...</span>
          <span v-else>Đổi Mật Khẩu</span>
        </button>
      </form>
      <p v-if="message" class="message" :class="messageType">{{ message }}</p>
    </div>
  </div>
</template>

<script>
import authService from '../../services/authService';

export default {
    name: 'ResetPasswordComponent',
    data() {
        return {
        password: '',
        password_confirmation: '',
        message: '',
        messageType: '',
        loading: false,
        };
    },
    mounted() {
    // Kiểm tra đã xác thực OTP chưa
        if (!localStorage.getItem('otp_verified')) {
            window.location.href = '/forgot-password';
        }
    },
    methods: {
        async submitResetPassword() {
            this.message = '';
            if (this.password.length < 6) {
                this.message = 'Mật khẩu mới phải có ít nhất 6 ký tự!';
                this.messageType = 'text-danger';
                return;
            }
            if (this.password !== this.password_confirmation) {
                this.message = 'Mật khẩu xác nhận không khớp!';
                this.messageType = 'text-danger';
                return;
            }
            this.loading = true;
            try {
                const response = await authService.resetPassword({
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                });
                if (response.data.status === 200) {
                    this.message = response.data.message || 'Đổi mật khẩu thành công!';
                    this.messageType = 'text-success';
                    localStorage.removeItem('otp_verified');
                    localStorage.removeItem('reset_email');
                    setTimeout(() => {
                        window.location.href = '/login';
                    }, 1500);
                } else {
                    this.message = response.data.message || 'Đổi mật khẩu thất bại!';
                    this.messageType = 'text-danger';
                }
            } catch (error) {
                this.message =
                error.response?.data?.message || 'Có lỗi xảy ra!';
                this.messageType = 'text-danger';
            } finally {
                this.loading = false;
            }
        },
    },
};
</script>

<style scoped>
.content {
  background-color: #e3f2fd;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 60vh;
}
.container1 {
  max-width: 400px;
  padding: 25px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  text-align: center;
  transition: box-shadow 0.3s ease-in-out;
}
.container1:hover {
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}
.btn-primary {
  background-color: #007bff;
  border: none;
  transition: all 0.3s ease;
}
.btn-primary:hover {
  background-color: #72be43;
  transform: translateY(-2px);
  box-shadow: 0 4px 10px rgba(114, 190, 67, 0.5);
}
.message {
  font-weight: bold;
  margin-top: 10px;
}
.text-success {
  color: #4caf50;
}
.text-danger {
  color: #dc3545;
}
</style>
