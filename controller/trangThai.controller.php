<?php
require_once "../model/trangThai.model.php";

class TrangThaiController {
    private $trangThaiModel;

    public function __construct() {
        $this->trangThaiModel = new TrangThaiModel();
    }

    public function getAllTrangThais() {
        $trangThais = $this->trangThaiModel->getAllTrangThais();

        return $trangThais;
    }

    public function getNameById($id) {
        $name = $this->trangThaiModel->getNameById($id);
        return $name;
    }

    public function getTrangThaiByType($type) {
        switch ($type) {
            case "donHang":
                $result = $this->trangThaiModel->getTrangThaiByType(5, 5);
                break;
            case "sanPham":
                $result = $this->trangThaiModel->getTrangThaiByType(2, 3);
                break;
            case "khac":
                $result = $this->trangThaiModel->getTrangThaiByType(3, 0);
                break;
        }
        
        echo json_encode(["trangThais" => $result]);
    }
}

if (isset($_GET['action']) && $_GET['action'] === "listTrangThai") {
    $controller = new TrangThaiController();
    $controller->getTrangThaiByType($_GET['type']);
}

?>