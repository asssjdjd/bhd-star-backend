import axiosInstance from "../axious/axious2";

const bookingTicketService = {
    getStep1(id) {
        return axiosInstance.get(`/user/step1/${id}`);
    },

    postStep2(data) {
        return axiosInstance.post("/user/step2", data);
    },

    postStep3(data) {
        return axiosInstance.post("/user/step3", data);
    },

    postStep4(data) {
        return axiosInstance.post("/user/step4", data);
    },
};

export default bookingTicketService;
