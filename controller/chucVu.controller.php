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

    public function listAllChucVus() {
        $chucVus = $this->chucVuModel->getAllChucVus();
        echo json_encode([
            "chucVus" => $chucVus
        ]);
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
        $result = $this->chucVuModel->addChucVu($data);

        echo json_encode(['success' => $result]);
    }

    public function getChucVuById($id) {
        $chucVu = $this->chucVuModel->getChucVuById($id);
        $quyens = $this->chucVuModel->getQuyensByChucVu($id);
        
        echo json_encode([
            "chucVu" => $chucVu,
            "quyens" => $quyens
        ]);
    }

    public function updateChucVu($data) {
        $result = $this->chucVuModel->updateChucVu($data);
        echo json_encode(['success' => $result]);
    }
}

if (isset($_GET['action'])) {
    $controller = new ChucVuController();
    switch ($_GET['action']) {
        case 'listAllChucVu':
            $controller->listAllChucVus();
            break;
        case 'listChucVu':
            $controller->listChucVus($_GET['limit']);
            break;
        case 'getChucVu':
            $controller->getChucVuById($_GET['id']);
            break;
    }
}

if (isset($_POST['action'])) {
    $controller = new ChucVuController();
    switch ($_POST['action']) {
        case 'addChucVu':
            $controller->addChucVu($_POST);
            break;
        case 'updateChucVu':
            $controller->updateChucVu($_POST);
            break;
    }
}
?>