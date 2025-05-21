<template>
    <div>
        <hr style="border: 1px solid #72be43; margin-left: 5%; margin-right: 5%; margin-top: 0px;">

        <div class="container mb-5" v-if="!loading">
            <!-- Shop controls -->
            <div class="shop-control d-flex justify-content-between">
                <div class="shop-control-left">
                    <select class="form-select" name="cinema" id="cinema-select" v-model="selectedTheaterId" @change="changeTheater">
                        <option v-for="theater in theaters" :key="theater.id" :value="theater.id">{{ theater.name }}</option>
                    </select>
                </div>
                <div class="shop-control-right">
                    <div class="cart position-relative">
                        <router-link to="/cart" class="text-decoration-none text-dark">
                            <i class="bi bi-cart-plus" :number="cartCount"></i>
                        </router-link>
                    </div>
                </div>
            </div>

            <!-- Tab navigation -->
            <div class="d-flex justify-content-center mt-3">
                <a href="#" class="button primary">Concession</a>
            </div>

            <!-- Food list -->
            <div class="row mt-5" id="food-list">
                <div v-for="food in foods" :key="food.id" class="col-12 col-md-6 col-lg-3 mb-4">
                    <div class="card ps-3">
                        <div class="thumb" style="height: 237px;">
                            <router-link :to="`/combo-detail/${food.id}`">
                                <img style="height: 100%;" :src="food.image" :alt="food.name">
                            </router-link>
                        </div>
                        <div class="info">
                            <router-link :to="`/combo-detail/${food.id}`" class="text-decoration-none">
                                <h4 class="title">{{ food.name }}</h4>
                            </router-link>
                            <p class="desc">
                                {{ food.description }}
                            </p>
                        </div>
                        <div class="stack mb-3">
                            <span class="ms-3">
                                <b>{{ formatPrice(food.price) }} VND</b>
                            </span>
                            <router-link :to="`/combo-detail/${food.id}`" class="btton primary me-3" style="float: right;">
                                Mua ngay
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-center my-5">
            <p>Đang tải dữ liệu...</p>
        </div>

        <hr style="border: 1px solid #72be43; margin-left: 5%; margin-right: 5%; margin-top: 0px;">
    </div>
</template>

<script>
import homeService from '../../services/homeService';

export default {
    name: 'ShopComponent',
    data() {
        return {
            theaters: [],
            foods: [],
            selectedTheaterId: null,
            cartCount: 0,
            loading: true
        };
    },
    methods: {
        async fetchShopData() {
            try {
                this.loading = true;
                const response = await homeService.getShop();
                console.log('Shop data:', response.data);

                this.theaters = response.data.theaters || [];
                
                // Set default theater if available
                if (this.theaters.length > 0 && !this.selectedTheaterId) {
                    this.selectedTheaterId = this.theaters[0].id;
                }
                
                // Filter foods for selected theater
                this.updateFoodsList(response.data.foods || []);
                
                // Get cart count from localStorage or session
                this.getCartCount();
                
                this.loading = false;
            } catch (error) {
                console.error('Error fetching shop data:', error);
                this.loading = false;
            }
        },
        
        updateFoodsList(allFoods) {
            if (this.selectedTheaterId) {
                // Filter foods by theater ID
                this.foods = allFoods.filter(food => food.theater_id == this.selectedTheaterId);
            } else {
                this.foods = allFoods;
            }
        },
        
        async changeTheater() {
            try {
                // Refetch data for the selected theater
                const response = await homeService.getShop();
                this.updateFoodsList(response.data.foods || []);
            } catch (error) {
                console.error('Error changing theater:', error);
            }
        },
        
        getCartCount() {
            // This would normally come from Vuex store or similar state management
            // For now, we'll use localStorage as a simple example
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            this.cartCount = cart.length;
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        }
    },
    mounted() {
        this.fetchShopData();
    }
};
</script>

<style scoped>
.primary {
    background-color: #72be43;
    color: white;
    text-decoration: none;
    padding: 8px 20px;
    border-radius: 5px;
    display: inline-block;
    transition: all 0.3s ease;
}

.primary:hover {
    background-color: #5ca32e;
}

.button {
    cursor: pointer;
    border: none;
    font-weight: 500;
}

.btton {
    cursor: pointer;
    border: none;
    font-weight: 500;
    padding: 5px 12px;
    border-radius: 3px;
}

.card {
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.thumb img {
    width: 100%;
    object-fit: cover;
    border-radius: 8px 8px 0 0;
}

.info {
    padding: 15px 10px;
}

.title {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.desc {
    font-size: 14px;
    color: #666;
    height: 60px;
    overflow: hidden;
}

.stack {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
}

.cart i {
    font-size: 24px;
    position: relative;
}

.cart i::after {
    content: attr(number);
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #72be43;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Add responsiveness */
@media (max-width: 768px) {
    .shop-control {
        flex-direction: column;
    }
    
    .shop-control-left, .shop-control-right {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>