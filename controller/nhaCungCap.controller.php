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

    public function listNhaCungCap() {
        $limit = 8;
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $result = $this->nhaCungCapModel->getNhaCungCaps($limit, $offset);
        $nhaCungCaps = $result->fetch_all(MYSQLI_ASSOC);
        $totalProducts = $this->nhaCungCapModel->getTotalNhaCungCaps();
        $totalPages = ceil($totalProducts / $limit);

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


}

if (isset($_GET['action']) && $_GET['action'] === 'listNhaCungCap') {
    $controller = new NhaCungCapController();
    $controller->listNhaCungCap();
}

?>