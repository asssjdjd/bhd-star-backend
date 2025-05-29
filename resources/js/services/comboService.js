import axiosInstance from "../axious/axious";

const comboService = {
    getCart() {
        return axiosInstance.get("/user/cart");
    },
    addToCart(payload) {
        return axiosInstance.post("/user/add-to-cart", payload);
    },
    updateCart(foodId, quantity) {
        return axiosInstance.post("/user/update-cart", { food_id: foodId, quantity });
    },
    deleteItem(foodId) {
        return axiosInstance.post(`/user/delete-item-cart`, { food_id: foodId });
    },
    confirmBooking(payload) {
        return axiosInstance.post("/user/success-buy-combo", payload);
    },
    getComboDetail(id) {
        return axiosInstance.get(`/user/combo-detail/${id}`);
    },
    refreshTheater() {
        return axiosInstance.post("/user/refresh-theater");
    }
};

export default comboService;
