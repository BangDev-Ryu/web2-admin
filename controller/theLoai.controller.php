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
}

if (isset($_GET['action']) && $_GET['action'] === 'listTheLoai') {
    $controller = new TheLoaiController();
    $controller->listTheLoai();
}
?>