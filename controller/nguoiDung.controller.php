<?php
require_once "../model/nguoiDung.model.php";

class nguoiDungController {
    private $nguoiDungModel;

    public function __construct() {
        $this->nguoiDungModel = new NguoiDungModel();
    }

    public function getAllNguoiDungs() {
        $nguoiDungs = $this->nguoiDungModel->getAllNguoiDungs();
        return $nguoiDungs;
    }

    public function getFullNameById($id) {
        $full_name = $this->nguoiDungModel->getFullNameById($id);
        return $full_name;
    }

    public function getEmailById($id) {
        $email = $this->nguoiDungModel->getEmailById($id);
        return $email;
    }

    public function getPhoneById($id) {
        $phone = $this->nguoiDungModel->getPhoneById($id);
        return $phone;
    }

    public function getPictureById($id) {
        $picture = $this->nguoiDungModel->getPictureById($id);
        return $picture;
    }

    public function getBirthDateById($id) {
        $birth_date = $this->nguoiDungModel->getBirthDateById($id);
        return $birth_date;
    }
}
?>