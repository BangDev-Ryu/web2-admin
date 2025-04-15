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
        $limit = 6;
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

    public function listTaiKhoanBySearch($limit, $search) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? $search : '';
        $search = strtolower($search);
        $taiKhoans = $this->taiKhoanModel->searchTaiKhoan($search, $limit, $offset);
        $totalTaiKhoans = $this->taiKhoanModel->getTotalSearchTaiKhoan($search);
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

    public function listTaiKhoanByFilter($limit, $filter) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $filter = isset($_GET['filter']) ? $filter : [];
        $taiKhoans = $this->taiKhoanModel->filterTaiKhoan($filter, $limit, $offset);

        $totalTaiKhoans = $this->taiKhoanModel->getTotalFilterTaiKhoan($filter);
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

    public function getTaiKhoanById($id) {
        $taiKhoan = $this->taiKhoanModel->getTaiKhoanById($id);
        echo json_encode(['taiKhoan' => $taiKhoan]);
    }

    public function addTaiKhoan($data) {
        $result = $this->taiKhoanModel->addTaiKhoan($data);
        echo json_encode(['success' => $result]);
    }
    
    public function updateTaiKhoan($data) {
        $result = $this->taiKhoanModel->updateTaiKhoan($data);
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
            $controller->listTaiKhoan($_GET['limit']);
            break;
        case 'listTaiKhoanBySearch':
            $controller->listTaiKhoanBySearch($_GET['limit'], $_GET['search']);
            break;
        case 'listTaiKhoanByFilter':
            $controller->listTaiKhoanByFilter($_GET['limit'], $_GET['filter']);
            break;
        case 'getTaiKhoanById':
            $controller->getTaiKhoanById($_GET['id']);
            break;
    }
}

if (isset($_POST['action'])) {
    $controller = new TaiKhoanController();
    $taiKhoanModel = new TaiKhoanModel();
    switch ($_POST['action']) {
        case 'addTaiKhoan':
            if(isset($_FILES['img'])) {
                $_POST['img'] = $_FILES['img'];
            }
            $controller->addTaiKhoan($_POST);
            break;
        case 'updateTaiKhoan':
            if(isset($_FILES['img'])) {
                $_POST['img'] = $_FILES['img'];
            }
            $controller->updateTaiKhoan($_POST);
            break;
        case 'deleteTaiKhoan':
            $controller->deleteTaiKhoan($_POST['id']);
            break;
        case "checkUniqueUsernameEmail":
            $username = $_POST["username"];
            $email = $_POST["email"];
            $id = $_POST["id"] ?? null; // ID để loại trừ tài khoản đang sửa
            $result = $taiKhoanModel->checkUniqueUsernameEmail($username, $email, $id);
            echo json_encode($result);
            break;
        
    }
}
?>