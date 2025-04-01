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

}

if (isset($_GET['action'])) {
    $controller = new SanPhamController();
    switch ($_GET['action']) {
        case 'listSanPham':
            $controller->listSanPham($_GET['limit'], $_GET['search']);
            break;
    }
}
?>