<?php
require_once "../model/taiKhoan.model.php";
require_once "./trangThai.controller.php";
require_once "./chucVu.controller.php";
require_once "./nguoiDung.controller.php";

class TaiKhoanController {
    private $taiKhoanModel;
    private $trangThaiController;
    private $chucVuController;
    private $nguoiDungController;

    public function __construct() {
        $this->taiKhoanModel = new TaiKhoanModel();
        $this->trangThaiController = new TrangThaiController();
        $this->chucVuController = new ChucVuController();
        $this->nguoiDungController = new NguoiDungController();
    }

    public function listAllTaiKhoan() {
        $result = $this->taiKhoanModel->getAllTaiKhoans();
        $taiKhoans = $result->fetch_all(MYSQLI_ASSOC);

        return $taiKhoans;
    }

    public function getUserNameById($id) {
        $username = $this->taiKhoanModel->getUserNameById($id);
        return $username;
    }

    public function listTaiKhoan() {
        $limit = 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $taiKhoans = $this->taiKhoanModel->getTaiKhoans($limit, $offset);
        $totalTaiKhoans = $this->taiKhoanModel->getTotalTaiKhoans();
        $totalPages = ceil($totalTaiKhoans / $limit);
        
        foreach ($taiKhoans as &$taiKhoan) {
            
            $role_name = $this->chucVuController->getNameById($taiKhoan['type_account']);
            $taiKhoan['role_name'] = $role_name;
            $username = $this->trangThaiController->getNameById($taiKhoan['trangthai_id']);
            $taiKhoan['trangthai_name'] = $username;
        }

        echo json_encode([
            "taiKhoans" => $taiKhoans,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function getTaiKhoan($id) {
        $taiKhoan = $this->taiKhoanModel->getTaiKhoanById($id);
        echo json_encode(['taiKhoan' => $taiKhoan]);
    }
}

if (isset($_GET['action'])) {
    $controller = new TaiKhoanController();
    switch ($_GET['action']) {
        case 'listTaiKhoan':
            $controller->listTaiKhoan();
            break;
        case 'getTheLoai':
            $controller->getTaiKhoan($_GET['id']);
            break;
        // case 'searchTheLoai':
        //     $controller->searchTaiKhoan($_GET['search']);
        //     break;
    }
}

// if (isset($_POST['action'])) {
//     $controller = new TaiKhoanController();
//     switch ($_POST['action']) {
//         case 'addTaiKhoan':
//             $controller->addTaiKhoan($_POST);
//             break;
//         case 'updateTaiKhoan':
//             $controller->updateTaiKhoan($_POST);
//             break;
//         case 'deleteTaiKhoan':
//             $controller->deleteTaiKhoan($_POST['id']);
//             break;
//     }
// }
?>