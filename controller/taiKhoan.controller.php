<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

    public function validateTaiKhoan($data, $isUpdate = false) {
        $errors = [];
        
        if (!preg_match('/^[a-zA-Z0-9]+$/', $data['username'])) {
            $errors[] = "Tên đăng nhập chỉ được chứa chữ cái và số, không dấu, không khoảng trắng và ký tự đặc biệt";
        }

        if (!$isUpdate || !empty($data['password'])) {
            if (strlen($data['password']) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự";
            }
        }

        if ($this->taiKhoanModel->checkEmailExists($data['email'], $isUpdate ? $data['id'] : null)) {
            $errors[] = "Email đã tồn tại trong hệ thống";
        }

        if ($this->taiKhoanModel->checkUsernameExists($data['username'], $isUpdate ? $data['id'] : null)) {
            $errors[] = "Tên đăng nhập đã tồn tại trong hệ thống";
        }

        if (!empty($data['date_of_birth'])) {
            if (!$this->taiKhoanModel->validateDateOfBirth($data['date_of_birth'])) {
                $errors[] = "Ngày sinh không hợp lệ";
            }
        }

        return $errors;
    }

    public function addTaiKhoan($data) {
        $errors = $this->validateTaiKhoan($data);
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        $result = $this->taiKhoanModel->addTaiKhoan($data);
        echo json_encode(['success' => $result]);
    }
    
    public function updateTaiKhoan($data) {
        $errors = $this->validateTaiKhoan($data, true);
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        $result = $this->taiKhoanModel->updateTaiKhoan($data);
        echo json_encode(['success' => $result]);
    }
    
    public function deleteTaiKhoan($id) {
        $existed = $this->taiKhoanModel->checkExistInPhieuBan($id);
        if ($existed) {
            $result = $this->taiKhoanModel->hideTaiKhoan($id);
        } else {
            $result = $this->taiKhoanModel->deleteTaiKhoan($id);
        }
        echo json_encode(['success' => $result]);
    }

    public function lockTaiKhoan($id) {
        $result = $this->taiKhoanModel->lockTaiKhoan($id);
        echo json_encode(['success' => $result]);
    }

    public function unlockTaiKhoan($id) {
        $result = $this->taiKhoanModel->unlockTaiKhoan($id);
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
        case 'getCurrentUser':
            $userId = $_SESSION['userId'];
            // $userInfo = $taiKhoanModel->getTaiKhoanById($userId);
            echo json_encode([
                'id' => $_SESSION['userId'],
                'fullname' => $_SESSION['usernameAdmin']
            ]);
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
        case 'lockTaiKhoan':
            $controller->lockTaiKhoan($_POST['id']);
            break;
        case 'unlockTaiKhoan':
            $controller->unlockTaiKhoan($_POST['id']);
            break;
    }
}
?>