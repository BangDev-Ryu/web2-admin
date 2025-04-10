<?php
require_once '../model/connect.php';

class DonHangModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }
   
    public function getDonHangs($status, $limit, $offset) {
        $sql = "SELECT * FROM phieuban
                WHERE trangthai_id = ?
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$status, $limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalDonHangs($status) {
        $sql = "SELECT COUNT(*) as total FROM phieuban
                WHERE trangthai_id = ?";
        $result = $this->db->executePrepared($sql, [$status]);
        return $result->fetch_assoc()['total'];
    }

    public function getDonHangById($id) {
        $sql = "SELECT * FROM phieuban WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

}
?>