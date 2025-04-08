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
            $taiKhoan['role_name'] = $taiKhoan['type_account'] == 1 ? "Người dùng" : "Admin";
            $tenchucvu = $this->chucVuController->getNameById($taiKhoan['chucvu_id']);
            $taiKhoan['chucvu'] = $tenchucvu;
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

    public function addTaiKhoan($data) {
        $result = $this->taiKhoanModel->addTaiKhoan(
            $data['username'],
            $data['password'],
            $data['trangthai_id'],
            $data['type_account']
        );
        if ($result) {
            $id = $this->taiKhoanModel->getLastInsertId();
            $this->nguoiDungController->addNguoiDung(
                $id,
                $data['taikhoan_id'],
                $data['fullname'],
                $data['email'],
                $data['phone'],
                $data['date_of_birth'],
                $data['chucvu_id'],
                $data['picture']    
            );
        }
        echo json_encode(['success' => $result]);
    }
    
    public function updateTaiKhoan($data) {
        $result = $this->taiKhoanModel->updateTaiKhoan(
            $data['id'],
            $data['username'],
            $data['password'],
            $data['trangthai_id'],
            $data['type_account']
        );
        if ($result) {
            $id = $this->taiKhoanModel->getLastInsertId();
            $this->nguoiDungController->updateNguoiDung(
                $id,
                $data['taikhoan_id'],
                $data['fullname'],
                $data['email'],
                $data['phone'],
                $data['date_of_birth'],
                $data['chucvu_id'],
                $data['picture']    
            );
        }
        echo json_encode(['success' => $result]);
    }
    
    public function deleteTaiKhoan($id) {
        $result = $this->taiKhoanModel->deleteTaiKhoan($id);
        echo json_encode(['success' => $result]);
    }

}

if (isset($_GET['action'])) {
    $controller = new TaiKhoanController();
    switch ($_GET['action']) {
        case 'listTaiKhoan':
            $controller->listTaiKhoan();
            break;
        case 'getTaiKhoan':
            $controller->getTaiKhoan($_GET['id']);
            break;
        // case 'searchTaiKhoan':
        //     $controller->searchTaiKhoan($_GET['search']);
        //     break;
    }
}

if (isset($_POST['action'])) {
    $controller = new TaiKhoanController();
    switch ($_POST['action']) {
        case 'addTaiKhoan':
            $controller->addTaiKhoan($_POST);
            break;
        case 'updateTaiKhoan':
            $controller->updateTaiKhoan($_POST);
            break;
        case 'deleteTaiKhoan':
            $controller->deleteTaiKhoan($_POST['id']);
            break;
    }
}
?>