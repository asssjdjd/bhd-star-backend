import axiosInstance from '../axious/axious';

const bookingTicketService = {
    // Step 1: Get initial booking info for a film
    getStep1(filmId) {
        return axiosInstance.get(`/user/step1/${filmId}`);
    },

    // Get showtimes for a specific date
    getShowtimesByDate(data) {
        return axiosInstance.post('/user/senday', data);
    },

    // Step 2: Get seat information
    getStep2(data) {
        return axiosInstance.post('/user/step2', data);
    },

    // Step 3: Get food combo information
    getStep3(data, params) {
        return axiosInstance.post('/user/step3', data, { 
            params: params 
        });
    },

    // Step 4: Get final booking details
    getStep4(data, params) {
        return axiosInstance.post('/user/step4', data, { 
            params: params 
        });
    },

    // Send booking confirmation email
    // Note: This endpoint appears to be missing from the api.php file
    // but exists in the TicketController
    sendSuccessBookingMail(data, params) {
        return axiosInstance.post('/user/send-success-booking-mail', data, {
            params: params
        });
    }
};

export default bookingTicketService;