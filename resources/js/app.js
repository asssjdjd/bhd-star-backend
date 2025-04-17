import { createApp } from 'vue';
import HomeComponent from './components/HomeComponent.vue';

const app = createApp({});
app.component('home-component', HomeComponent);
app.mount('#app');