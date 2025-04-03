<?php
require_once "../model/sanPham.model.php";
require_once "./trangThai.controller.php";
require_once "./theLoai.controller.php";

class SanPhamController {
    private $sanPhamModel;
    private $trangThaiController;
    private $theLoaiController;

    public function __construct() {
        $this->sanPhamModel = new SanPhamModel();
        $this->trangThaiController = new TrangThaiController();
        $this->theLoaiController = new TheLoaiController();
    }

    public function listSanPham($limit, $search) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? $search : '';

        if (empty($search)) {
            $products = $this->sanPhamModel->getSanPhams($limit, $offset);
            $totalProducts = $this->sanPhamModel->getTotalSanPhams();
        }
        else {
            $search = strtolower($search);
            $products = $this->sanPhamModel->searchSanPham($search, $limit, $offset);
            $totalProducts = $this->sanPhamModel->getTotalSearchSanPham($search);
        }
        $totalPages = ceil($totalProducts / $limit);
        
        foreach ($products as &$product) {
            $trangThaiName = $this->trangThaiController->getNameById($product['trangthai_id']);
            $theLoaiName = $this->theLoaiController->getNameById($product['theloai_id']);
            $product['theloai_name'] = $theLoaiName;
            $product['trangthai_name'] = $trangThaiName;
        }

        echo json_encode([
            "products" => $products,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

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
            $theLoaiName = $this->theLoaiController->getNameById($product['theloai_id']);
            $product['theloai_name'] = $theLoaiName;
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
            $controller->listSanPham($_GET['limit'], $_GET['search']);
            break;
        case 'getSanPham':
            $controller->getSanPhamById($_GET['id']);
            break;
    }
} else if (isset($_POST['action'])) {
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