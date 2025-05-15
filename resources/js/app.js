import { createApp } from 'vue';
import Toast from 'vue-toastification';
import 'vue-toastification/dist/index.css';

import HomeComponent from './components/HomeComponent.vue';
import LoginComponent from './components/LoginComponet.vue';
import AdminComponent from './components/AdminComponent.vue';
import CategoryComponent from './components/Catogory/CategoryComponent.vue';
import CreateCategoryComponent from './components/Catogory/CreateCategoryComponent.vue';
import AdminFilmComponent from './components/Film/AdminFilmComponent.vue';
import ShowtimeFilmComponent from './components/Film/ShowtimeFilmComponent.vue'

const app = createApp({});
// Sử dụng Toastification với cấu hình
app.component('home-component', HomeComponent);
app.component('login-component', LoginComponent);
app.component('admin-component', AdminComponent);
app.component('category-component', CategoryComponent);
app.component('create-category-component', CreateCategoryComponent);
app.component('admin-showtime-component',ShowtimeFilmComponent)
app.component('admin-film-component',AdminFilmComponent)
app.mount('#app');