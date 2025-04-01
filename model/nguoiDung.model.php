<?php
require_once '../model/connect.php';

class NguoiDungModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalNguoiDungs() {
        return $this->db->totalByCondition('nguoidung', '', '1=1', []);
    }

    public function getAllNguoiDungs() {
        $result = $this->db->selectAll("nguoidung");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getFullNameById($id) {
        $sql = "SELECT fullname FROM nguoidung WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['fullname'];
    }

    public function getEmailById($id) {
        $sql = "SELECT email FROM nguoidung WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['email'];
    }

    public function getPhoneById($id) {
        $sql = "SELECT phone FROM nguoidung WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['phone'];
    }   

    public function getPictureById($id) {
        $sql = "SELECT picture FROM nguoidung WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['picture'];
    }

    public function getBirthDateById($id) {
        $sql = "SELECT date_of_birth FROM nguoidung WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['date_of_birth'];
    }
}
?>