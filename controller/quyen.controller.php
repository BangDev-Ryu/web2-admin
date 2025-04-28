<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class QuyenController {
    public function checkQuyenSideBar() {
        if (!isset($_SESSION['quyens'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Không có quyền truy cập'
            ]);
            return;
        }

        // Nhóm các quyền xem theo chức năng
        $quyens = [];
        foreach ($_SESSION['quyens'] as $quyen) {
            switch ($quyen['quyen_id']) {
                case 1: // Xem trang chủ
                    $quyens[] = ['id' => 1];
                    break;
                case 5: // Xem sản phẩm  
                    $quyens[] = ['id' => 5];
                    break;
                case 9: // Xem đơn hàng
                    $quyens[] = ['id' => 9];
                    break;
                case 13: // Xem thể loại
                    $quyens[] = ['id' => 13];
                    break;
                case 17: // Xem chủ đề
                    $quyens[] = ['id' => 17];
                    break;
                case 21: // Xem tài khoản
                    $quyens[] = ['id' => 21];
                    break;
                case 25: // Xem chức vụ
                    $quyens[] = ['id' => 25];
                    break;
                case 29: // Xem phiếu nhập
                    $quyens[] = ['id' => 29];
                    break;
                case 33: // Xem nhà cung cấp
                    $quyens[] = ['id' => 33];
                    break;
                case 37: // Xem khuyến mãi
                    $quyens[] = ['id' => 37];
                    break;
            }
        }

        echo json_encode([
            'success' => true,
            'quyens' => $quyens
        ]);
    }

    public function checkQuyen() {
        if (!isset($_SESSION['quyens'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Không có quyền truy cập'
            ]);
            return;
        }

        $quyens = array_column($_SESSION['quyens'], 'quyen_id');
        

        echo json_encode([
            'success' => true,
            'quyens' => $quyens
        ]);
    }
}

// Xử lý các request
if (isset($_GET['action'])) {
    $controller = new QuyenController();
    
    switch ($_GET['action']) {
        case 'checkQuyenSideBar':
            $controller->checkQuyenSideBar();
            break;
        case 'checkQuyen':
            $controller->checkQuyen();
            break;
    }
}
?>