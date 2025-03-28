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
}

?>