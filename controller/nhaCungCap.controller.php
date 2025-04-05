<?php
require_once "../model/nhaCungCap.model.php";
require_once "./trangThai.controller.php";

class NhaCungCapController {
    private $nhaCungCapModel;
    private $trangThaiController;

    public function __construct() {
        $this->nhaCungCapModel = new NhaCungCapModel();
        $this->trangThaiController = new TrangThaiController();
    }

    public function getNameById($id) {
        $name = $this->nhaCungCapModel->getNameById($id);
        return $name;
    }

    public function listNhaCungCap($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $nhaCungCaps = $this->nhaCungCapModel->getNhaCungCaps($limit, $offset);
       
        $totalProducts = $this->nhaCungCapModel->getTotalNhaCungCaps();
        $totalPages = ceil($totalProducts / $limit);

        foreach ($nhaCungCaps as &$nhaCungCap) {
            $trangThaiName = $this->trangThaiController->getNameById($nhaCungCap['trangthai_id']);
            $nhaCungCap['trangthai_name'] = $trangThaiName;
        }
        

        echo json_encode([
            "nhaCungCaps" => $nhaCungCaps,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }




public function getNhaCungCap($id) {
    $nhaCungCap = $this->nhaCungCapModel->getNhaCungCapById($id);
    echo json_encode(['nhaCungCap' => $nhaCungCap]);
}

public function addNhaCungCap($data) {
    $result = $this->nhaCungCapModel->addNhaCungCap($data);
    echo json_encode(['success' => $result]);
}

public function updateNhaCungCap($data) {
    $result = $this->nhaCungCapModel->updateNhaCungCap($data);
    echo json_encode(['success' => $result]);
}

public function deleteNhaCungCap($id) {
    $result = $this->nhaCungCapModel->deleteNhaCungCap($id);
    echo json_encode(['success' => $result]);
}

public function searchNhaCungCap($search) {
    $search = strtolower($search);
    $nhaCungCaps = $this->nhaCungCapModel->searchNhaCungCap($search);
    foreach ($nhaCungCaps as &$nhaCungCap) {
        $name = $this->trangThaiController->getNameById($nhaCungCap['trangthai_id']);
        $nhaCungCap['trangthai_name'] = $name;
    }
    echo json_encode(['nhaCungCaps' => $nhaCungCaps]);
}
}

// Xử lý các request
if (isset($_GET['action'])) {
$controller = new NhaCungCapController();
switch ($_GET['action']) {
    case 'listNhaCungCap':
        $controller->listNhaCungCap($_GET['limit']);
        break;
    case 'getNhaCungCap':
        $controller->getNhaCungCap($_GET['id']);
        break;
    case 'searchNhaCungCap':
        $controller->searchNhaCungCap($_GET['search']);
        break;
}
}

if (isset($_POST['action'])) {
$controller = new NhaCungCapController();
switch ($_POST['action']) {
    case 'addNhaCungCap':
        $controller->addNhaCungCap($_POST);
        break;
    case 'updateNhaCungCap':
        $controller->updateNhaCungCap($_POST);
        break;
    case 'deleteNhaCungCap':
        $controller->deleteNhaCungCap($_POST['id']);
        break;
}
}




?>