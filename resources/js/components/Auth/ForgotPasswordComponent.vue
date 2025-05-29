<template>
    <div class="content">
        <div class="container1 d-flex flex-column gap-3">
            <h3 class="mb-3 text-primary">🔑 Quên Mật Khẩu</h3>
            <p class="text-muted">Nhập email để nhận liên kết đặt lại mật khẩu</p>
            <form @submit.prevent="submitForgotPassword" class="d-flex flex-column gap-3">
                <div class="input-group mb-3">
                    <input
                        v-model="email"
                        type="email"
                        class="form-control"
                        placeholder="Nhập email của bạn"
                        required
                    />
                </div>
                <button type="submit" class="btn btn-primary w-100" :disabled="loading">
                    <span v-if="loading">Đang gửi...</span>
                    <span v-else>Gửi Yêu Cầu</span>
                </button>
                <div v-if="message" :class="['message', messageType === 'success' ? 'text-success' : 'text-danger']">
                    {{ message }}
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import authService from '../../services/authService';

export default {
    name: 'ForgotPasswordComponent',
    data() {
        return {
        email: '',
        message: '',
        messageType: 'error',
        loading: false,
        };
    },
    methods: {
        async submitForgotPassword() {
            this.message = '';
            this.loading = true;
            try {
                const response = await authService.forgotPassword({ email: this.email });
                if (response.status === 200) {
                    this.message = response.data.message || 'Mã OTP đã được gửi đến email của bạn';
                    this.messageType = 'success';
                    localStorage.setItem('email', this.email); 
                    setTimeout(() => {
                        window.location.href = '/otp';
                    }, 1000); // Redirect after 2 seconds
                } else {
                    this.message = response.data.message || 'Có lỗi xảy ra!';
                    this.messageType = 'error';
                }
            } catch (error) {
                this.message = error.response?.data?.message || 'Có lỗi xảy ra!';
                this.messageType = 'error';
            } finally {
                this.loading = false;
            }
            },
        },
    };
</script>

<style scoped>
.content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 50vh;
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
