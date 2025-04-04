<?php
require_once "../model/khuyenMai.model.php";
class KhuyenMaiController {
    private $khuyenMaiModel;

    public function __construct() {
        $this->khuyenMaiModel = new KhuyenmaiModel();
    }

    public function getNameById($id) {
        $name = $this->khuyenMaiModel->getNameById($id);
        return $name;
    }

    public function listKhuyenMai($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $khuyenMais = $this->khuyenMaiModel->getKhuyenMais($limit, $offset);
       
        $totalProducts = $this->khuyenMaiModel->getTotalKhuyenMais();
        $totalPages = ceil($totalProducts / $limit);

        echo json_encode([
            "khuyenMais" => $khuyenMais,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }




public function getKhuyenMai($id) {
    $khuyenMai = $this->khuyenMaiModel->getKhuyenMaiById($id);
    echo json_encode(['khuyenMai' => $khuyenMai]);
}

public function addKhuyenMai($data) {
    $result = $this->khuyenMaiModel->addKhuyenMai($data);
    echo json_encode(['success' => $result]);
}

public function updateKhuyenMai($data) {
    $result = $this->khuyenMaiModel->updateKhuyenMai($data);
    echo json_encode(['success' => $result]);
}

public function deleteKhuyenMai($id) {
    $result = $this->khuyenMaiModel->deleteKhuyenMai($id);
    echo json_encode(['success' => $result]);
}

public function searchKhuyenMai($search) {
    $search = strtolower($search);
    $khuyenMais = $this->khuyenMaiModel->searchKhuyenMai($search);
    echo json_encode(['khuyenMais' => $khuyenMais]);
}
}

// Xử lý các request
if (isset($_GET['action'])) {
$controller = new KhuyenMaiController();
switch ($_GET['action']) {
    case 'listKhuyenMai':
        $controller->listKhuyenMai($_GET['limit']);
        break;
    case 'getKhuyenMai':
        $controller->getKhuyenMai($_GET['id']);
        break;
    case 'searchKhuyenMai':
        $controller->searchKhuyenMai($_GET['search']);
        break;
}
}

if (isset($_POST['action'])) {
$controller = new KhuyenMaiController();
switch ($_POST['action']) {
    case 'addKhuyenMai':
        $controller->addKhuyenMai($_POST);
        break;
    case 'updateKhuyenMai':
        $controller->updateKhuyenMai($_POST);
        break;
    case 'deleteKhuyenMai':
        $controller->deleteKhuyenMai($_POST['id']);
        break;
}
}




?>