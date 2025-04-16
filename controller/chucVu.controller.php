<?php
require_once "../model/chucVu.model.php";

class ChucVuController {
    private $chucVuModel;

    public function __construct() {
        $this->chucVuModel = new ChucVuModel();
    }

    public function getAllChucVus() {
        $chucVus = $this->chucVuModel->getAllChucVus();

        return $chucVus;
    }

    public function getNameById($id) {
        $role_name = $this->chucVuModel->getNameById($id);
        return $role_name;
    }

    public function listChucVus($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $chucVus = $this->chucVuModel->getChucVus($limit, $offset);
        $totalChucVus = $this->chucVuModel->getTotalChucVus();
        $totalPages = ceil($totalChucVus / $limit);

        echo json_encode([
            "chucVus" => $chucVus,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function addChucVu($data) {
        // $role_name = $data['role_name'];
        // $description = $data['description'];
        // $quyens = isset($data['quyens']) ? $data['quyens'] : [];

        // if (empty($role_name) || empty($description)) {
        //     echo json_encode([
        //         "status" => "error",
        //         "message" => "Vui lòng nhập đầy đủ thông tin."
        //     ]);
        //     return;
        // }

        // if (count($quyens) == 0) {
        //     echo json_encode([
        //         "status" => "error",
        //         "message" => "Vui lòng chọn ít nhất một quyền."
        //     ]);
        //     return;
        // }

        $result = $this->chucVuModel->addChucVu($data);

        echo json_encode(['success' => $result]);
    }
}

if (isset($_GET['action'])) {
    $controller = new ChucVuController();
    switch ($_GET['action']) {
        case 'listChucVu':
            $controller->listChucVus($_GET['limit']);
            break;
        // case 'listChucVuBySearch':
        //     $controller->listChucVuBySearch($_GET['limit'], $_GET['search']);
        //     break;
    }
}

if (isset($_POST['action'])) {
    $controller = new ChucVuController();
    switch ($_POST['action']) {
        case 'addChucVu':
            $controller->addChucVu($_POST);
            break;
        
    }
}
?>