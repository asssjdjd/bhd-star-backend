<template>
    <div class="container mt-5">
        <div class="row">
            <!-- Hình ảnh sản phẩm -->
            <div class="col-md-6 text-center">
                <img :src="food.image" alt="Combo Sweet" class="img-fluid" style="max-height: 700px;">
            </div>
            <!-- Thông tin sản phẩm -->
            <div class="col-md-6">
                <h3 class="fw-bold" style="color: #72be43">{{ food.name }}</h3>
                <br>
                <hr class="my-line">

                <p>{{ food.description }}</p>
                <p>Giá bán : <span class="fw-bold" style="color: #72be43">{{ formatCurrency(food.price) }}</span> <b>VND</b></p>

                <div class="d-flex align-items-center">
                    <span class="me-3"> Số lượng : </span>
                    <button class="btn btn-outline-secondary me-2" @click="decreaseQuantity">-</button>
                    <span>{{ quantity }}</span>
                    <button class="btn btn-outline-secondary ms-2" @click="increaseQuantity">+</button>
                </div>

                <br>
                <hr class="my-line">

                <h5 class="mt-3 mb-3">Tổng tiền: <span style="color: #72be43">{{ formatCurrency(totalPrice) }}</span> VND</h5>
                <div class="d-flex">
                    <button class="btn btn-outline-dark" @click="addToCart">THÊM VÀO GIỎ</button>
                    <button class="btn btn-success ms-2" @click="buyNow">MUA</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import comboService from '../../services/comboService';
import { useToast } from 'vue-toastification';

export default {
    name: "ComboDetailComponent",
    data() {
        return {
            food: {},
            quantity: 1,
        };
    },
    computed: {
        totalPrice() {
            return this.food.price * this.quantity;
        },
    },
    methods: {
        fetchComboDetail() {
             const pathParts = window.location.pathname.split('/');
            const id = pathParts[pathParts.length - 1];
            comboService.getComboDetail(id).then((response) => {
                if (response.status === 200) {
                    this.food = response.data.food;
                } else {
                    this.toast.error("Không tìm thấy combo!");
                }
            });
        },
        formatCurrency(value) {
            return new Intl.NumberFormat("vi-VN", { style: "currency", currency: "VND" }).format(value);
        },
        increaseQuantity() {
            this.quantity++;
        },
        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },
        addToCart() {
            const payload = {
                food_id: this.food.id,
                quantity: this.quantity,
                food_name: this.food.name,
                food_price: this.food.price,
                food_image: this.food.image,
                food_description: this.food.description,
            };

            console.log(payload); // Kiểm tra dữ liệu gửi lên
            comboService.addToCart(payload).then((response) => {
                if (response.status === 200) {
                    this.toast.success(response.data.message);
                } else {
                    this.toast.error("Không thể thêm vào giỏ hàng!");
                }
                console.log(response);
            });
        },
        buyNow() {
            const payload = {
                food_id: this.food.id,
                quantity: this.quantity,
                food_name: this.food.name,
                food_price: this.food.price,
                food_image: this.food.image,
                food_description: this.food.description,
            };

            console.log(payload); 
            comboService.addToCart(payload).then((response) => {
                if (response.status === 200) {
                    this.toast.success(response.data.message);
                    window.location.href = '/cart';
                } else {
                    this.toast.error("Không thể mua combo!");
                }
            });
        }
    },
    mounted() {
        this.toast = useToast();
        this.fetchComboDetail();
    },
};
</script>

<style scoped>
.img-fluid {
    width: 100%;
}
.my-line {
    border: none;
    border-top: 1px solid #000;
    margin: 10px 0;
}
</style>
