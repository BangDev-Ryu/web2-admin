<?php
require_once "../model/khuyenMai.model.php";
class KhuyenMaiController {
    private $khuyenMaiModel;

    public function __construct() {
        $this->khuyenMaiModel = new KhuyenmaiModel();
    }

    public function listKhuyenMai($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        $khuyenMais = $this->khuyenMaiModel->getKhuyenMais($limit, $offset);
        $totalKhuyenMais = $this->khuyenMaiModel->getTotalKhuyenMais();
        $totalPages = ceil($totalKhuyenMais / $limit);
        
        echo json_encode([
            "khuyenMais" => $khuyenMais,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function listKhuyenMaiBySearch($limit, $search) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
    
        $search = isset($_GET['search']) ? $search : '';
    
        $search = strtolower($search);
        $khuyenMais = $this->khuyenMaiModel->searchKhuyenMai($search, $limit, $offset);
        $totalKhuyenMais = $this->khuyenMaiModel->getTotalSearchKhuyenMai($search);
        $totalPages = ceil($totalKhuyenMais / $limit);
    
        echo json_encode([
            "khuyenMais" => $khuyenMais,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function listKhuyenMaiByFilter($limit, $filter) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $filter = isset($_GET['filter']) ? $filter : [];
        $khuyenMais = $this->khuyenMaiModel->filterKhuyenMai($filter, $limit, $offset);

        $totalKhuyenMais = $this->khuyenMaiModel->getTotalFilterKhuyenMai($filter);
        $totalPages = ceil($totalKhuyenMais / $limit);
        

        echo json_encode([
            "khuyenMais" => $khuyenMais,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }
    
    

    public function getKhuyenMaiById($id) {
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

    // public function deleteKhuyenMai($id) {
    //     $existed = $this->khuyenMaiModel->checkExistInPhieuBan($id);
    //     if ($existed) {
    //         $result = $this->khuyenMaiModel->hideKhuyenMai($id);
    //     } else {
    //         $result = $this->khuyenMaiModel->deleteKhuyenMai($id);
    //     } echo json_encode(['success' => $result]);
    // }
}

// Xử lý các request
if (isset($_GET['action'])) {
$controller = new KhuyenMaiController();
switch ($_GET['action']) {
    case 'listKhuyenMai':
        $controller->listKhuyenMai($_GET['limit']);
        break;
        case 'listKhuyenMaiBySearch':
            $controller->listKhuyenMaiBySearch($_GET['limit'], $_GET['search']);
            break;
        case 'listKhuyenMaiByFilter':
            $controller->listKhuyenMaiByFilter($_GET['limit'], $_GET['filter']);
            break;
    case 'getKhuyenMai':
        $controller->getKhuyenMaiById($_GET['id']);
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