<template>
    <div>
      <app-navbar></app-navbar>
      <div class="container mt-4">
        <h1>Chào mừng đến với Trang Quản Trị</h1>
        <p>Chọn một mục từ thanh điều hướng để quản lý dữ liệu.</p>
      </div>
    </div>
  </template>
  
  <script>
  import { defineComponent } from 'vue';
  
  export default defineComponent({
    name: 'AdminComponent',
    components: {
      AppNavbar: {
        template: `
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Quản Trị Hệ Thống</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link" href="/admin/category">Quản Lý Danh Mục</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/admin/film">Quản Lý Phim</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/admin/foodcombo">Quản Lý Combo Đồ Ăn</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/admin/promotion">Quản Lý Khuyến Mãi</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="/admin/theater">Quản Lý Rạp</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>
        `
      }
    }
  });
  </script>
  
  <style>
  /* Thêm style tùy chỉnh nếu cần */
  </style>