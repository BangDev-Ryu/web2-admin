<?php
require_once "../model/theLoai.model.php";
require_once "./trangThai.controller.php";

class TheLoaiController {
    private $theLoaiModel;
    private $trangThaiController;

    public function __construct() {
        $this->theLoaiModel = new TheLoaiModel();
        $this->trangThaiController = new TrangThaiController();
    }

    public function listAllTheLoai() {
        $result = $this->theLoaiModel->getAllTheLoais();
        $theLoais = $result->fetch_all(MYSQLI_ASSOC);

        return $theLoais;
    }

    public function getNameById($id) {
        $name = $this->theLoaiModel->getNameById($id);
        return $name;
    }

    public function listTheLoai() {
        $limit = 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $theLoais = $this->theLoaiModel->getTheLoais($limit, $offset);
        $totalTheLoais = $this->theLoaiModel->getTotalTheLoais();
        $totalPages = ceil($totalTheLoais / $limit);
        
        foreach ($theLoais as &$theLoai) {
            $name = $this->trangThaiController->getNameById($theLoai['trangthai_id']);
            $theLoai['trangthai_name'] = $name;
        }

        echo json_encode([
            "theLoais" => $theLoais,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function getTheLoai($id) {
        $theLoai = $this->theLoaiModel->getTheLoaiById($id);
        echo json_encode(['theLoai' => $theLoai]);
    }

    public function addTheLoai($data) {
        $result = $this->theLoaiModel->addTheLoai($data);
        echo json_encode(['success' => $result]);
    }

    public function updateTheLoai($data) {
        $result = $this->theLoaiModel->updateTheLoai($data);
        echo json_encode(['success' => $result]);
    }

    public function deleteTheLoai($id) {
        $result = $this->theLoaiModel->deleteTheLoai($id);
        echo json_encode(['success' => $result]);
    }

    public function searchTheLoai($search) {
        $theLoais = $this->theLoaiModel->searchTheLoai($search);
        foreach ($theLoais as &$theLoai) {
            $name = $this->trangThaiController->getNameById($theLoai['trangthai_id']);
            $theLoai['trangthai_name'] = $name;
        }
        echo json_encode(['theLoais' => $theLoais]);
    }
}

// Xử lý các request
if (isset($_GET['action'])) {
    $controller = new TheLoaiController();
    switch ($_GET['action']) {
        case 'listTheLoai':
            $controller->listTheLoai();
            break;
        case 'getTheLoai':
            $controller->getTheLoai($_GET['id']);
            break;
        case 'searchTheLoai':
            $controller->searchTheLoai($_GET['search']);
            break;
    }
}

if (isset($_POST['action'])) {
    $controller = new TheLoaiController();
    switch ($_POST['action']) {
        case 'addTheLoai':
            $controller->addTheLoai($_POST);
            break;
        case 'updateTheLoai':
            $controller->updateTheLoai($_POST);
            break;
        case 'deleteTheLoai':
            $controller->deleteTheLoai($_POST['id']);
            break;
    }
}
?>