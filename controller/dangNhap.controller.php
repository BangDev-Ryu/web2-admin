<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../model/taiKhoan.model.php');

class DangNhapController {
    private $taiKhoanModel;

    public function __construct() {
        $this->taiKhoanModel = new TaiKhoanModel();
    }
    
    public function login($username, $password) {
        $result = $this->taiKhoanModel->checkLogin($username, $password);
        
        if ($result['success']) {
            // Lưu thông tin user vào session
            $_SESSION['usernameAdmin'] = $username;
            $_SESSION['userId'] = $result['id'];
            $_SESSION['roleId'] = $result['role_id'];
            
            return [
                'success' => true,
                'message' => 'Đăng nhập thành công'
            ];
        }
        
        return [
            'success' => false,
            'message' => 'Tên đăng nhập hoặc mật khẩu không đúng'
        ];
    }

    public function logout() {
        session_unset();
        session_destroy();
        
        header('Location: ../view/pages/dangNhap.php');
        exit();
    }

}

// Phần xử lý AJAX
if (isset($_POST['action'])) {
    $controller = new DangNhapController();
    
    switch ($_POST['action']) {
        case 'login':
            $result = $controller->login($_POST['username'], $_POST['password']);
            echo json_encode($result);
            break;
            
        case 'logout':
            $controller->logout();
            break;
    }
}
?>