<?php
require_once "../model/sanPham.model.php";

class SanPhamController {
    private $sanPhamModel;

    public function __construct() {
        $this->sanPhamModel = new SanPhamModel();
    }

    public function listSanPham() {
        $limit = 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $result = $this->sanPhamModel->getProducts($limit, $offset);
        $products = $result->fetch_all(MYSQLI_ASSOC);
        $totalProducts = $this->sanPhamModel->getTotalProducts();
        $totalPages = ceil($totalProducts / $limit);

        echo json_encode([
            "products" => $products,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }


}

if (isset($_GET['action']) && $_GET['action'] === 'list') {
    $controller = new SanPhamController();
    $controller->listSanPham();
}

?>