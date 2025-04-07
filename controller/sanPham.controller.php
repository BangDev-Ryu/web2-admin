<?php
require_once "../model/sanPham.model.php";
require_once "./trangThai.controller.php";
require_once "./chuDe.controller.php";

class SanPhamController {
    private $sanPhamModel;
    private $trangThaiController;
    private $chuDeController;

    public function __construct() {
        $this->sanPhamModel = new SanPhamModel();
        $this->trangThaiController = new TrangThaiController();
        $this->chuDeController = new ChuDeController();
    }

    // load danh sách sản phẩm
    public function listSanPham($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $products = $this->sanPhamModel->getSanPhams($limit, $offset);
        $totalProducts = $this->sanPhamModel->getTotalSanPhams();
        $totalPages = ceil($totalProducts / $limit);
        
        foreach ($products as &$product) {
            $trangThaiName = $this->trangThaiController->getNameById($product['trangthai_id']);
            $chuDeName = $this->chuDeController->getNameById($product['chude_id']);
            $product['chude_name'] = $chuDeName;
            $product['trangthai_name'] = $trangThaiName;
        }

        echo json_encode([
            "products" => $products,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    // load danh sách sản phẩm theo search
    public function listSanPhamBySearch($limit, $search) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? $search : '';
        $search = strtolower($search);
        $products = $this->sanPhamModel->searchSanPham($search, $limit, $offset);
        $totalProducts = $this->sanPhamModel->getTotalSearchSanPham($search);
        $totalPages = ceil($totalProducts / $limit);
        
        foreach ($products as &$product) {
            $trangThaiName = $this->trangThaiController->getNameById($product['trangthai_id']);
            $chuDeName = $this->chuDeController->getNameById($product['chude_id']);
            $product['chude_name'] = $chuDeName;
            $product['trangthai_name'] = $trangThaiName;
        }

        echo json_encode([
            "products" => $products,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    // load danh sách sản phẩm theo filter
    public function listSanPhamByFilter($limit, $filter) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $filter = isset($_GET['filter']) ? $filter : [];
        $products = $this->sanPhamModel->filterSanPham($filter, $limit, $offset);

        $totalProducts = $this->sanPhamModel->getTotalFilterSanPham($filter);
        $totalPages = ceil($totalProducts / $limit);
        
        foreach ($products as &$product) {
            $trangThaiName = $this->trangThaiController->getNameById($product['trangthai_id']);
            $chuDeName = $this->chuDeController->getNameById($product['chude_id']);
            $product['chude_name'] = $chuDeName;
            $product['trangthai_name'] = $trangThaiName;
        }

        echo json_encode([
            "products" => $products,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function getSanPhamById($id) {
        $sanPham = $this->sanPhamModel->getSanPhamById($id);
        echo json_encode(['sanPham' => $sanPham]);
    }

    public function addSanPham($data) {
        $result = $this->sanPhamModel->addSanPham($data);
        echo json_encode(['success' => $result]);
    }

    public function updateSanPham($data) {
        $result = $this->sanPhamModel->updateSanPham($data);
        echo json_encode(['success' => $result]);
    }
    
}

if (isset($_GET['action'])) {
    $controller = new SanPhamController();
    switch ($_GET['action']) {
        case 'listSanPham':
            $controller->listSanPham($_GET['limit']);
            break;
        case 'listSanPhamBySearch':
            $controller->listSanPhamBySearch($_GET['limit'], $_GET['search']);
            break;
        case 'listSanPhamByFilter':
            $controller->listSanPhamByFilter($_GET['limit'], $_GET['filter']);
            break;
        case 'getSanPham':
            $controller->getSanPhamById($_GET['id']);
            break;
    }
}

if (isset($_POST['action'])) {
    $controller = new SanPhamController();
    switch ($_POST['action']) {
        case 'addSanPham':
            $controller->addSanPham($_POST);
            break;
        case 'updateSanPham':
            $controller->updateSanPham($_POST);
            break;
    }
}
?>