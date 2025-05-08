import { createApp } from 'vue';
import HomeComponent from './components/HomeComponent.vue';
import LoginComponent from'./components/LoginComponet.vue';
// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// import 'bootstrap-icons/font/bootstrap-icons.css';

const app = createApp({});
app.component('home-component', HomeComponent);
app.component('login-component', LoginComponent); 
app.mount('#app');