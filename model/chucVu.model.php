<?php
require_once '../model/connect.php';

class ChucVuModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalChucVus() {
        return $this->db->totalByCondition('chucvu', '', '1=1', []);
    }

    public function getAllChucVus() {
        $result = $this->db->selectAll("chucvu");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNameById($id) {
        $sql = "SELECT role_name FROM chucvu WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['role_name'];
    }

    public function getChucVuByType($limit, $offset) {
        $sql = "SELECT * FROM chucvu
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>