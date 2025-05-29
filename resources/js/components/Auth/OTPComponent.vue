<template>
    <div class="content">
        <div class="container1">
            <h3 class="mb-3 text-primary">🔐 Xác Nhận OTP</h3>
            <p class="text-muted">Nhập mã OTP gồm 6 chữ số</p>
            <form @submit.prevent="submitOtp" class="mb-2">
                <div class="d-flex justify-content-center mb-3">
                <input
                    v-for="(digit, idx) in otpDigits"
                    :key="idx"
                    type="text"
                    maxlength="1"
                    class="otp-input form-control"
                    v-model="otpDigits[idx]"
                    @input="focusNext(idx, $event)"
                    @keydown.backspace="focusPrev(idx, $event)"
                    required
                />
                </div>
                <button type="submit" class="btn btn-primary w-100" :disabled="loading">Xác Nhận</button>
            </form>
            <p v-if="message" class="message" :class="messageType">{{ message }}</p>
            <form @submit.prevent="resendOtp" class="mb-3">
                <button type="submit" class="text-success mt-4" :disabled="resending">
                <span v-if="resending">Đang gửi lại...</span>
                <span v-else>Gửi Lại</span>
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import authService from '../../services/authService';

export default {
  name: 'OTPComponent',
  data() {
    return {
      otpDigits: ['', '', '', '', '', ''],
      message: '',
      messageType: '',
      loading: false,
      resending: false,
    };
  },
  methods: {
    async submitOtp() {
      this.message = '';
      this.loading = true;
      const otp = this.otpDigits.join('');
      if (otp.length !== 6 || !/^\d{6}$/.test(otp)) {
        this.message = 'Vui lòng nhập đủ 6 số OTP!';
        this.messageType = 'text-danger';
        this.loading = false;
        return;
      }
      try {
        const response = await authService.verifyOtp({ otp });
        if (response.data.status === 200) {
          this.message = response.data.message || 'Xác thực thành công!';
          this.messageType = 'text-success';
          // Có thể chuyển hướng sang trang đổi mật khẩu ở đây
          setTimeout(() => {
            window.location.href = '/reset-password';
          }, 1000);
        } else {
          this.message = response.data.message || 'Mã OTP không chính xác!';
          this.messageType = 'text-danger';
        }
      } catch (error) {
        this.message = error.response?.data?.message || 'Có lỗi xảy ra!';
        this.messageType = 'text-danger';
      } finally {
        this.loading = false;
      }
    },
    async resendOtp() {
      this.resending = true;
      this.message = '';
      try {
        // Lấy email từ localStorage hoặc sessionStorage nếu cần
        const email = localStorage.getItem('reset_email');
        const response = await authService.forgotPassword({ email });
        if (response.data.status === 200) {
          this.message = response.data.message || 'Đã gửi lại mã OTP!';
          this.messageType = 'text-success';
        } else {
          this.message = response.data.message || 'Không gửi lại được mã OTP!';
          this.messageType = 'text-danger';
        }
      } catch (error) {
        this.message = error.response?.data?.message || 'Có lỗi xảy ra!';
        this.messageType = 'text-danger';
      } finally {
        this.resending = false;
      }
    },
    focusNext(idx, event) {
      if (event.target.value.length === 1 && idx < 5) {
        this.$el.querySelectorAll('.otp-input')[idx + 1].focus();
      }
    },
    focusPrev(idx, event) {
      if (event.target.value === '' && idx > 0) {
        this.$el.querySelectorAll('.otp-input')[idx - 1].focus();
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
.otp-input {
  width: 50px;
  height: 50px;
  text-align: center;
  font-size: 24px;
  font-weight: bold;
  margin: 5px;
  border-radius: 8px;
  border: 2px solid #ccc;
  transition: all 0.3s ease;
}
.otp-input:focus {
  border-color: #007bff;
  box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
  outline: none;
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
