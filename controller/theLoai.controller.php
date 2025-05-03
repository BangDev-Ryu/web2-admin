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

    public function listAllTheLoais() {
        $theLoais = $this->theLoaiModel->getAllTheLoais();
        echo json_encode(['theLoais' => $theLoais]);
    }

    public function listTheLoai($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $theLoais = $this->theLoaiModel->getTheLoais($limit, $offset);
        $totalTheLoais = $this->theLoaiModel->getTotalTheLoais();
        $totalPages = ceil($totalTheLoais / $limit);
        
        foreach ($theLoais as &$theLoai) {
            $trangThaiName = $this->trangThaiController->getNameById($theLoai['trangthai_id']);
            $theLoai['trangthai_name'] = $trangThaiName;
        }

        echo json_encode([
            "theLoais" => $theLoais,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function listTheLoaiBySearch($limit, $search) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? $search : '';

        $search = strtolower($search);
        $theLoais = $this->theLoaiModel->searchTheLoai($search, $limit, $offset);
        $totalTheLoais = $this->theLoaiModel->getTotalSearchTheLoai($search);
        $totalPages = ceil($totalTheLoais / $limit);
        
        foreach ($theLoais as &$theLoai) {
            $trangThaiName = $this->trangThaiController->getNameById($theLoai['trangthai_id']);
            $theLoai['trangthai_name'] = $trangThaiName;
        }

        echo json_encode([
            "theLoais" => $theLoais,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }
        

        public function listTheLoaiByFilter($limit, $filter) {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page - 1) * $limit;
    
            $filter = isset($_GET['filter']) ? $filter : [];
            $theLoais = $this->theLoaiModel->filterTheLoai($filter, $limit, $offset);
    
            $totalTheLoais = $this->theLoaiModel->getTotalFilterTheLoai($filter);
            $totalPages = ceil($totalTheLoais / $limit);
            
            foreach ($theLoais as &$theLoai) {
                $trangThaiName = $this->trangThaiController->getNameById($theLoai['trangthai_id']);
                $theLoai['trangthai_name'] = $trangThaiName;
            }
    
            echo json_encode([
                "theLoais" => $theLoais,
                "totalPages" => $totalPages,
                "currentPage" => $page
            ]);
        }


    public function getNameById($id) {
        $name = $this->theLoaiModel->getNameById($id);
        return $name;
    }

    public function getTheLoaiById($id) {
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
        $existed = $this->theLoaiModel->checkExistInChuDe($id);
        if ($existed) {
            $result = $this->theLoaiModel->hideTheLoai($id);
        } else {
            $result = $this->theLoaiModel->deleteTheLoai($id);
        }
        echo json_encode([
            'success' => $result
        ]);
    }
}

// Xử lý các request
if (isset($_GET['action'])) {
    $controller = new TheLoaiController();
    $limit = isset($_GET['limit']) && intval($_GET['limit']) > 0 ? intval($_GET['limit']) : 10; // gán mặc định nếu thiếu

    switch ($_GET['action']) {
        case 'listAllTheLoai':
            $controller->listAllTheLoais();
            break;
        case 'listTheLoai':
            $controller->listTheLoai($limit);
            break;

        case 'listTheLoaiBySearch':
            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $controller->listTheLoaiBySearch($limit, $search);
            break;

        case 'listTheLoaiByFilter':
            $filter = isset($_GET['filter']) ? $_GET['filter'] : [];
            $controller->listTheLoaiByFilter($limit, $filter);
            break;

        case 'getTheLoai':
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            if ($id !== null) {
                $controller->getTheLoaiById($id); 
            }
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