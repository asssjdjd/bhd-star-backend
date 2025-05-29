import axios from '../axious/axious';

const authService = {
  forgotPassword(payload) {
    return axios.post('/forgot-password', payload);
  },
  verifyOtp(payload) {
    return axios.post('/otp', payload);
  },
  resetPassword(payload) {
    return axios.post('/reset-password', payload);
  },
};

export default authService;
