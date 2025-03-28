<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css?v=<?php echo time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <?php 
        include_once("./view/sidebar.php");
    ?>
    <div id="content">
        <?php
            $validPages = ['trangChu', 'sanPham', 'donHang', 'theLoai', 'taiKhoan', 'quyen', 'nhapHang', 'nhaCungCap', 'khuyenMai'];

            // Kiểm tra trang từ URL, nếu không hợp lệ thì về home
            $page = isset($_GET['page']) && in_array($_GET['page'], $validPages) ? $_GET['page'] : 'trangChu';

            // Định nghĩa đường dẫn file
            $viewPath = "view/pages/{$page}.php";

            // Kiểm tra file trước khi require
            if (file_exists($viewPath)) {
                require_once($viewPath);
            } else {
                echo '<h2>Trang không tồn tại</h2>';
            }

        ?>
    </div>
    
</body>
</html>