<?php
require_once "../model/chuDe.model.php";
require_once "./trangThai.controller.php";

class ChuDeController {
    private $chuDeModel;
    private $trangThaiController;

    public function __construct() {
        $this->chuDeModel = new ChuDeModel();
        $this->trangThaiController = new TrangThaiController();
    }

    public function listAllChuDe() {
        $chuDes = $this->chuDeModel->getAllChuDes();
        echo json_encode(['chuDes' => $chuDes]);
    }

    public function getNameById($id) {
        $name = $this->chuDeModel->getNameById($id);
        return $name;
    }

    public function getChuDe($id) {
        $chuDe = $this->chuDeModel->getChuDeById($id);
        echo json_encode(['chuDe' => $chuDe]);
    }

    
}

if (isset($_GET['action'])) {
    $chuDeController = new ChuDeController();
    switch ($_GET['action']) {
        case 'listAllChuDe':
            $chuDeController->listAllChuDe();
            break;
    }
}