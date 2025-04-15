<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/sidebar.css?v=<?php echo time(); ?>" />
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.min.css">
    
    <script src="./js/sidebar.js?v=<?= time() ?>"></script>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-shop menu-icon"></i>
            <span class="logo-name">LEGO</span>
        </div>

        <div class="sidebar-content">
            <ul class="item-list">
                <li class="item">
                    <a href="#" class="nav-link" data-page="trangChu">
                        <i class="fa-solid fa-house icon"></i>
                        <span class="link">Trang chủ</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="sanPham">
                        <i class="fa-solid fa-box icon"></i>
                        <span class="link">Sản phẩm</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="donHang">
                        <i class="fa-solid fa-cart-shopping icon"></i>
                        <span class="link">Đơn hàng</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="theLoai">
                        <i class="fa-solid fa-list icon"></i>
                        <span class="link">Thể loại</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="chuDe">
                        <i class="fa-solid fa-flag icon"></i>
                        <span class="link">Chủ đề</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="taiKhoan">
                        <i class="fa-solid fa-user icon"></i>
                        <span class="link">Tài khoản</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="chucVu">
                        <i class="fa-solid fa-wrench icon"></i>
                        <span class="link">Chức vụ</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="phieuNhap">
                        <i class="fa-solid fa-truck-fast icon"></i>
                        <span class="link">Phiếu nhập</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="nhaCungCap">
                        <i class="fa-solid fa-building-user icon"></i>
                        <span class="link">Nhà cung cấp</span>
                    </a>
                </li>

                <li class="item">
                    <a href="#" class="nav-link" data-page="khuyenMai">
                        <i class="fa-solid fa-tags icon"></i>
                        <span class="link">Khuyến mãi</span>
                    </a>
                </li>
            </ul>

            <div class="bottom-content">
                <li class="item">
                    <a href="" class="nav-link">
                        <i class="fa-solid fa-right-from-bracket icon"></i>
                        <span class="link">Đăng xuất</span>
                    </a>
                </li>
            </div>
            
        </div>
    </div>
</body>
</html>