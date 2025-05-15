<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once('../model/taiKhoan.model.php');
include_once('../model/nguoiDung.model.php');
include_once('../model/chucVu.model.php');

class DangNhapController {
    private $taiKhoanModel;
    private $nguoiDungModel;
    private $chucVuModel;

    public function __construct() {
        $this->taiKhoanModel = new TaiKhoanModel();
        $this->nguoiDungModel = new NguoiDungModel();
        $this->chucVuModel = new ChucVuModel();
    }
    
    public function login($username, $password) {
        $result = $this->taiKhoanModel->checkLogin($username, $password);
        
        if ($result['success']) {
            // Lưu thông tin user vào session
            $_SESSION['usernameAdmin'] = $username;
            $_SESSION['userId'] = $result['id'];
            $chucVuId = $this->nguoiDungModel->getChucVuById($result['id']);
            $quyens = $this->chucVuModel->getQuyensByChucVu($chucVuId);
            
            $_SESSION['quyens'] = $quyens;
            
            return [
                'success' => true,
                'message' => 'Đăng nhập thành công'
            ];
        }
        
        return [
            'success' => false,
            'message' => $result['message']
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