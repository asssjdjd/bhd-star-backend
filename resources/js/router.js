import { createRouter, createWebHistory } from 'vue-router';
import CategoryComponent from './components/CategoryCompoent.vue';
import CreateCategoryComponent from './components/CreateCategoryComponent.vue';

const routes = [
  { path: '/admin/category', component: CategoryComponent },
  { path: '/admin/create-category', component: CreateCategoryComponent },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
