<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Quản Trị')</title>
    @vite(['resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/admin">Quản Trị Hệ Thống</a>
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

        <!-- Main Content -->
        <div class="container mt-4">
            @yield('content')
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>