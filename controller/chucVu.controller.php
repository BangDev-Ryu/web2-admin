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
?>