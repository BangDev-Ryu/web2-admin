<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../model/connect.php');

if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $viewPath = '';

    switch ($page) {
        case "sanPham":
            $viewPath = '../view/pages/sanPham.php';
            break;
        case "donHang":
            $viewPath = '../view/pages/donHang.php';
            break;
        case "theLoai":
            $viewPath = '../view/pages/theLoai.php';
            break;
        case "chuDe":
            $viewPath = '../view/pages/chuDe.php';
            break;
        case "taiKhoan":
            $viewPath = '../view/pages/taiKhoan.php';
            break;  
        case "chucVu":
            $viewPath = '../view/pages/chucVu.php';
            break;
        case "phieuNhap":
            $viewPath = '../view/pages/phieuNhap.php';
            break;
        case "nhaCungCap":
            $viewPath = '../view/pages/nhaCungCap.php';
            break;
        case "khuyenMai":
            $viewPath = '../view/pages/khuyenMai.php';
            break;
        default:
            $viewPath = '../view/pages/trangChu.php';
            break;
    }

    // Trả về nội dung trang
    if (file_exists($viewPath)) {
        ob_start(); // Bắt đầu bộ đệm đầu ra
        require_once($viewPath);
        $content = ob_get_clean(); // Lấy nội dung từ bộ đệm
        echo $content; // Trả về nội dung cho AJAX
    } else {
        echo '<h2>Trang không tồn tại</h2>';
    }
} else {
    echo '<h2>Trang không hợp lệ</h2>';
}