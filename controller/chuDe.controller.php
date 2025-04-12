<?php
require_once "../model/chuDe.model.php";
require_once "./theLoai.controller.php";
require_once "./trangThai.controller.php";


class ChuDeController {
    private $chuDeModel;
    private $theLoaiController;
    private $trangThaiController;

    public function __construct() {
        $this->chuDeModel = new ChuDeModel();
        $this->theLoaiController = new TheLoaiController();
        $this->trangThaiController = new TrangThaiController();
    }

    public function listChuDe($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $chuDes = $this->chuDeModel->getChuDes($limit, $offset);
        $totalChuDes = $this->chuDeModel->getTotalChuDes();
        $totalPages = ceil($totalChuDes / $limit);
        
        foreach ($chuDes as &$chuDe) {
            $trangThaiName = $this->trangThaiController->getNameById($chuDe['trangthai_id']);
            $chuDe['trangthai_name'] = $trangThaiName;
            $theLoaiName = $this->theLoaiController->getNameById($chuDe['theloai_id']);
            $chuDe['theloai_name'] = $theLoaiName;
        }

        echo json_encode([
            "chuDes" => $chuDes,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function listChuDeBySearch($limit, $search) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        
    $search = isset($_GET['search']) ? strtolower($_GET['search']) : '';

        $search = strtolower($search);
        $chuDes = $this->chuDeModel->searchChuDe($search, $limit, $offset);
        $totalChuDes = $this->chuDeModel->getTotalSearchChuDe($search);
        $totalPages = ceil($totalChuDes / $limit);
        
        foreach ($chuDes as & $chuDe) {
            $trangThaiName = $this->trangThaiController->getNameById($chuDe['trangthai_id']);
            $chuDe['trangthai_name'] = $trangThaiName;
            $theLoaiName = $this->theLoaiController->getNameById($chuDe['theloai_id']);
            $chuDe['theloai_name'] = $theLoaiName;
        }

        echo json_encode([
            "chuDes" => $chuDes,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function listChuDeByFilter($limit, $filter) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $filter = isset($_GET['filter']) ? $filter : [];
        $chuDes = $this->chuDeModel->filterChuDe($filter, $limit, $offset);

        $totalChuDes = $this->chuDeModel->getTotalFilterChuDe($filter);
        $totalPages = ceil($totalChuDes / $limit);
        
        foreach ($chuDes as &$chuDe) {
            $trangThaiName = $this->trangThaiController->getNameById($chuDe['trangthai_id']);
            $chuDe['trangthai_name'] = $trangThaiName;
            $theLoaiName = $this->theLoaiController->getNameById($chuDe['theloai_id']);
            $chuDe['theloai_name'] = $theLoaiName;
        }

        echo json_encode([
            "chuDes" => $chuDes,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function getNameById($id) {
        $name = $this->chuDeModel->getNameById($id);
        return $name;
    }
    public function getChuDeById($id) {
        $chuDe = $this->chuDeModel->getChuDeById($id);
        echo json_encode(['chuDe' => $chuDe]);
    }

    public function addChuDe($data) {
        $result = $this->chuDeModel->addChuDe($data);
        echo json_encode(['success' => $result]);
    }
    
    public function updateChuDe($data) {
        $result = $this->chuDeModel->updateChuDe($data);
        echo json_encode(['success' => $result]);
    }
    
    public function deleteChuDe($id) {
        $result = $this->chuDeModel->deleteChuDe($id);
        echo json_encode(['success' => $result]);
    }
    
}

if (isset($_GET['action'])) {
    $controller = new ChuDeController();
    switch ($_GET['action']) {
        case 'listChuDe':
            $controller->listChuDe($_GET['limit']);
            break;
            case 'listChuDeBySearch':
                $controller->listChuDeBySearch($_GET['limit'], $_GET['search']);
                break;
            case 'listChuDeByFilter':
                $controller->listChuDeByFilter($_GET['limit'], $_GET['filter']);
                break;  
        case 'getChuDe':
            $controller->getChuDeById($_GET['id']);
            break;
        }
    }


    if (isset($_POST['action'])) {
        $controller = new ChuDeController();
        switch ($_POST['action']) {
            case 'addChuDe':
                $controller->addChuDe($_POST);
                break;
            case 'updateChuDe':
                $controller->updateChuDe($_POST);
                break;
            case 'deleteChuDe':
                $controller->deleteChuDe($_POST['id']);
                break;
            }   
        }

?>