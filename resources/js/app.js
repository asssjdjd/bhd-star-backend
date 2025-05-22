import { createApp } from 'vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

import HomeComponent from './components/HomeComponent.vue';
import LoginComponent from './components/Auth/LoginComponet.vue';
import AdminComponent from './components/AdminComponent.vue';
import CategoryComponent from './components/Catogory/CategoryComponent.vue';
import CreateCategoryComponent from './components/Catogory/CreateCategoryComponent.vue';
import AdminFilmComponent from './components/Film/AdminFilmComponent.vue';
import ShowtimeFilmComponent from './components/Film/ShowtimeFilmComponent.vue'
import CreateFilmComponent from './components/Film/CreateFilmComponent.vue';
import EditFilmComponent from './components/Film/EditFilmComponent.vue';
import TheaterSystemComponent from './components/TheaterSystemComponent.vue';
import TheaterDetailComponent from './components/TheaterDetailComponent.vue';
import UserPromotionComponent from './components/UserPromotionComponent.vue';
import MovieScheduleComponent from './components/MovieScheduleComponent.vue';
import TheaterScheduleComponent from './components/TheaterScheduleComponent.vue';
import TheaterScheduleDetailComponent from './components/TheaterScheduleDetailComponent.vue';

import FoodComboComponent from './components/FoodCombo/FoodComboComponent.vue';
import CreateFoodComboComponent from './components/FoodCombo/CreateFoodComboComponent.vue';
import EditFoodComboComponent from './components/FoodCombo/EditFoodComboComponent.vue';
import TheaterComponent from './components/Theater/TheaterComponent.vue';
import CreateTheaterComponent from './components/Theater/CreateTheaterComponent.vue';
import EditTheaterComponent from './components/Theater/EditTheaterComponent.vue';
import PromotionComponent from './components/Promotion/PromotionComponent.vue';
import CreatePromotionComponent from './components/Promotion/CreatePromotionComponent.vue';
import EditPromotionComponent from './components/Promotion/EditPromotionComponent.vue';
import ShopComponent from './components/User/ShopComponent.vue';

import Step1Component from './components/Booking/Step1Component.vue';
import Step2Component from './components/Booking/Step2Component.vue';
import Step3Component from './components/Booking/Step3Component.vue';
import Step4Component from './components/Booking/Step4Component.vue';
import PageComponent from './components/PageComponent.vue'; 


const app = createApp({});
// Sử dụng Toastification với cấu hình
app.component('home-component', HomeComponent);
app.component('login-component', LoginComponent);
app.component('admin-component', AdminComponent);
app.component('category-component', CategoryComponent);
app.component('create-category-component', CreateCategoryComponent);
app.component('admin-showtime-component',ShowtimeFilmComponent)
app.component('admin-film-component',AdminFilmComponent)
app.component('create-film-component',CreateFilmComponent)
app.component('edit-film-component',EditFilmComponent)
app.component('theater-component', TheaterSystemComponent);
app.component('theater-detail-component', TheaterDetailComponent);
app.component('promotion-component', UserPromotionComponent);
app.component('movie-schedule-component', MovieScheduleComponent);
app.component('theater-schedule-component', TheaterScheduleComponent);
app.component('theater-schedule-detail-component', TheaterScheduleDetailComponent);

app.component('admin-foodcombo-component', FoodComboComponent)
app.component('admin-create-foodcombo-component', CreateFoodComboComponent)
app.component('admin-edit-foodcombo-component', EditFoodComboComponent)

app.component('admin-theater-component', TheaterComponent)
app.component('admin-create-theater-component', CreateTheaterComponent)
app.component('admin-edit-theater-component', EditTheaterComponent)

app.component('admin-promotion-component', PromotionComponent)
app.component('admin-create-promotion-component', CreatePromotionComponent)
app.component('admin-edit-promotion-component', EditPromotionComponent)

app.component('step1-component', Step1Component)
app.component('step2-component', Step2Component)
app.component('step3-component', Step3Component)
app.component('step4-component', Step4Component)
app.component('page-component', PageComponent)


app.component('shop-component',ShopComponent)
app.mount('#app');