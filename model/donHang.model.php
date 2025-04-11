<?php
require_once '../model/connect.php';

class DonHangModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalDonHangs() {
        return $this->db->totalByCondition('phieuban', '', '1=1', []);
    }

    public function getDonHangs($limit, $offset) {
        $sql = "SELECT * FROM phieuban
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDonHangById($id) {
        $sql = "SELECT * FROM phieuban WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

}
?>