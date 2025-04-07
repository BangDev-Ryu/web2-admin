<?php
require_once "../model/chucVu.model.php";

class ChucVuController {
    private $chucVuModel;

    public function __construct() {
        $this->chucVuModel = new ChucVuModel();
    }

    public function getAllChucVus() {
        $chucVus = $this->chucVuModel->getAllChucVus();

        return $chucVus;
    }

    public function getNameById($id) {
        $role_name = $this->chucVuModel->getNameById($id);
        return $role_name;
    }

    public function getChucVuByType($type) {
        switch ($type) {
            case "taiKhoan":
                $result = $this->chucVuModel->getChucVuByType(3, 0);
                break;
        }
        
        echo json_encode(["chucVus" => $result]);
    }


}

if (isset($_GET['action']) && $_GET['action'] === "listChucVu") {
    $controller = new ChucVuController();
    $controller->getChucVuByType($_GET['type']);
}
?>