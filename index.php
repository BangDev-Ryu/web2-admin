<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['usernameAdmin'])) {
        header("Location: ./view/pages/dangNhap.php");
        exit();
    }
    // $list_quyen_id = array_column($_SESSION['quyens'], 'quyen_id');
    // echo '<pre>';
    // foreach($list_quyen_id as $quyen_id) {
    //     echo $quyen_id . '<br>';
    // }
    // echo '</pre>';
?>

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
            $validPages = [];
            foreach ($_SESSION['quyens'] as $quyen) {
                switch ($quyen['quyen_id']) {
                    case 1: // Xem trang chủ
                        $validPages[] = ['trangChu'];
                        break;
                    case 5: // Xem sản phẩm  
                        $validPages[] = ['sanPham'];
                        break;
                    case 9: // Xem đơn hàng
                        $validPages[] = ['donHang'];
                        break;
                    case 13: // Xem thể loại
                        $validPages[] = ['theLoai'];
                        break;
                    case 17: // Xem chủ đề
                        $validPages[] = ['chuDe'];
                        break;
                    case 21: // Xem tài khoản
                        $validPages[] = ['taiKhoan'];
                        break;
                    case 25: // Xem chức vụ
                        $validPages[] = ['chucVu'];
                        break;
                    case 29: // Xem phiếu nhập
                        $validPages[] = ['phieuNhap'];
                        break;
                    case 33: // Xem nhà cung cấp
                        $validPages[] = ['nhaCungCap'];
                        break;
                    case 37: // Xem khuyến mãi
                        $validPages[] = ['khuyenMai'];
                        break;
                }
            }


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