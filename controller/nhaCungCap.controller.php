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

    public function listAllNhaCungCap() {
        $nhaCungCaps = $this->nhaCungCapModel->getAllNhaCungCaps();
        
        echo json_encode(['nhaCungCaps' => $nhaCungCaps]);
    }

    public function listNhaCungCap($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $nhaCungCaps = $this->nhaCungCapModel->getNhaCungCaps($limit, $offset);
        $totalNhaCungCaps = $this->nhaCungCapModel->getTotalNhaCungCaps();
        $totalPages = ceil($totalNhaCungCaps / $limit);
        
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

    public function listNhaCungCapBySearch($limit, $search) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? $search : '';

        $search = strtolower($search);
        $nhaCungCaps = $this->nhaCungCapModel->searchNhaCungCap($search, $limit, $offset);
        $totalNhaCungCaps = $this->nhaCungCapModel->getTotalSearchNhaCungCap($search);
        $totalPages = ceil($totalNhaCungCaps / $limit);
        
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

    public function listNhaCungCapByFilter($limit, $filter) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $filter = isset($_GET['filter']) ? $filter : [];
        $nhaCungCaps = $this->nhaCungCapModel->filterNhaCungCap($filter, $limit, $offset);

        $totalNhaCungCaps = $this->nhaCungCapModel->getTotalFilterNhaCungCap($filter);
        $totalPages = ceil($totalNhaCungCaps / $limit);
        
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

    public function getNameById($id) {
        $name = $this->nhaCungCapModel->getNameById($id);
        echo json_encode(['name' => $name]);
    }

    public function getNhaCungCapById($id) {
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
        $existed = $this->nhaCungCapModel->checkExistInPhieuNhap($id);
        if ($existed) {
            $result = $this->nhaCungCapModel->hideNhaCungCap($id);
        } else {
            $result = $this->nhaCungCapModel->deleteNhaCungCap($id);
        } echo json_encode(['success' => $result]);
    }

}

// Xử lý các request
if (isset($_GET['action'])) {
$controller = new NhaCungCapController();
switch ($_GET['action']) {
    case 'listNhaCungCap':
        $controller->listNhaCungCap($_GET['limit']);
        break;
    case 'listNhaCungCapBySearch':
        $controller->listNhaCungCapBySearch($_GET['limit'], $_GET['search']);
        break;
    case 'listNhaCungCapByFilter':
        $controller->listNhaCungCapByFilter($_GET['limit'], $_GET['filter']);
        break;  
    case 'getNhaCungCap':
        $controller->getNhaCungCapById($_GET['id']);
        break;
    case 'listAllNhaCungCap':
        $controller->listAllNhaCungCap();
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