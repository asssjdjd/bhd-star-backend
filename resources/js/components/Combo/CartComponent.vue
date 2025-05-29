<template>
    <div class="container mt-4">
        <div class="row">
            <!-- Phần chi tiết đơn hàng -->
            <div class="card col-md-6">
                <h5 class="text-success mt-3 mb-3">Chi tiết đơn hàng</h5>
                <button class="btn btn-green mb-3 w-25">NHẬN TẠI RẠP</button>

                <!-- Item -->
                <div v-for="food in cart" :key="food.id" class="item mb-3">
                    <h3 style="color: #72be43">{{ food.name }}</h3>
                    <p>{{ food.description }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <button @click="removeItem(food.id)" class="text-danger btn btn-sm">
                                <i class="fa-solid fa-circle-xmark me-3"></i>
                            </button>
                            <img :src="food.image" width="50px" alt="Popcorn" class="me-2">
                            <span class="discount-price ms-2">
                                {{ formatCurrency(food.quantity * food.price) }}
                            </span>
                        </div>
                        <div class="quantity d-flex align-items-center">
                            <button class="btn btn-outline-secondary btn-sm" @click="decreaseQuantity(food.id)">-</button>
                            <span class="mx-2">{{ food.quantity }}</span>
                            <button class="btn btn-outline-secondary btn-sm" @click="increaseQuantity(food.id)">+</button>
                        </div>
                    </div>
                </div>

                <!-- Tổng tiền -->
                <div class="total mt-4 d-flex justify-content-around">
                    <h4 style="color: #72be43">Tổng tiền</h4>
                    <h5>{{ formatCurrency(totalPrice) }}</h5>
                </div>
            </div>

            <!-- Phần thông tin khách hàng -->
            <div class="col-md-6">
                <div class="card p-3">
                    <div class="d-flex justify-content-between">
                        <h6>Ngày nhận hàng</h6>
                        <input type="date" v-model="selectedDate" class="form-control w-50">
                    </div>
                    <hr>
                    <h6>Họ tên</h6>
                    <p>{{ user.name }}</p>
                    <h6>Số điện thoại</h6>
                    <p>{{ user.phone }}</p>
                    <h6>Email</h6>
                    <p>{{ user.email }}</p>
                    <h6>Cụm rạp</h6>
                    <p>{{ theater.name }}</p>
                    <h6>Địa chỉ</h6>
                    <p>{{ theater.address }}</p>
                    <h6>Hình thức thanh toán</h6>
                    <div class="payment-methods">
                        <div class="form-check" v-for="method in paymentMethods" :key="method.id">
                            <input class="form-check-input" type="radio" name="payment" :id="method.id" v-model="selectedPayment">
                            <label class="form-check-label" :for="method.id">{{ method.label }}</label>
                        </div>
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" v-model="agreedTerms">
                        <label class="form-check-label">
                            Tôi đã đọc và đồng ý với <a href="#">Điều khoản thanh toán</a>.
                        </label>
                    </div>
                    <button class="btn btn-green w-100 mt-3" :disabled="!agreedTerms" @click="confirmBooking">
                        XÁC NHẬN
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import comboService from '../../services/comboService';

export default {
    name: "CartComponent",
    data() {
        return {
            cart: [],
            theater: {},
            user: {
                name: "Nguyen Van A",
                phone: "0123456789",
                email: "example@gmail.com",
            },
            selectedDate: new Date().toISOString().slice(0, 10),
            paymentMethods: [
                { id: "vnpay", label: "Thanh toán qua VNPAY (Visa, Master, Amex, JCB...)" },
                { id: "zalopay", label: "Zalopay QR đa năng" },
                { id: "momo", label: "Thanh toán bằng Ví điện tử MoMo" },
                { id: "shopeepay", label: "Thanh toán qua SHOPEEPAY" },
            ],
            selectedPayment: null,
            agreedTerms: false,
        };
    },
    computed: {
        totalPrice() {
            return this.cart.reduce((total, item) => total + item.quantity * item.price, 0);
        },
    },
    methods: {
        fetchCart() {
            comboService.getCart().then((response) => {
                console.log(response); // Kiểm tra dữ liệu trả về
                if (response.status === 200) {
                    this.cart = response.data.cart.map((item) => ({
                        id: item.id,
                        name: item.name,
                        quantity: item.quantity,
                        price: item.price,
                        image: item.image,
                        description: item.description,
                    }));
                    this.theater = response.data.theater || {};
                    this.user = response.data.user.map((user) => ({
                        name: user.surname + " " + user.name,
                        phone: user.phone,
                        email: user.email,
                    }))[0] || this.user; // Lấy thông tin người dùng từ response
                } else {
                    alert("Không thể lấy giỏ hàng!");
                }
            });
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(value);
        },
        increaseQuantity(id) {
            const item = this.cart.find((food) => food.id === id);
            if (item) {
                item.quantity++;
                comboService.updateCart(id, item.quantity).then(this.fetchCart);
            }
        },
        decreaseQuantity(id) {
            const item = this.cart.find((food) => food.id === id);
            if (item && item.quantity > 1) {
                item.quantity--;
                comboService.updateCart(id, item.quantity).then(this.fetchCart);
            }
        },
        removeItem(id) {
            comboService.deleteItem(id).then(this.fetchCart);
        },
        confirmBooking() {
            const payload = {
                date: this.selectedDate,
                totalCost: this.totalPrice,
                combos: this.cart.map((item) => ({
                    id: item.id,
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price,
                })),
            };

            console.log(payload)

            comboService.confirmBooking(payload).then((response) => {
                if (response.status === 200) {
                    alert(response.data.message);
                    this.fetchCart(); // Làm mới giỏ hàng
                } else {
                    alert("Không thể xác nhận đặt hàng!");
                }
            });
        },
    },
    mounted() {
        this.fetchCart();
    },
};
</script>

<style scoped>
.active-day {
    background-color: #72be43;
    color: white;
    border-radius: 50%;
}
.discount-price {
    color: black;
    font-weight: bold;
}
.btn-green {
    background-color: #4caf50;
    color: white;
    border-radius: 5px;
    padding: 8px 15px;
    border: none;
    width: 100%;
    font-size: 16px;
}
</style>
