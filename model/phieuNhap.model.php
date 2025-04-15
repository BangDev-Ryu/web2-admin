<?php
require_once '../model/connect.php';

class PhieuNhapModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }
   
    public function getPhieuNhaps($status, $limit, $offset) {
        $sql = "SELECT * FROM phieunhap
                WHERE trangthai_id = ?
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$status, $limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalPhieuNhaps($status) {
        $sql = "SELECT COUNT(*) as total FROM phieunhap
                WHERE trangthai_id = ?";
        $result = $this->db->executePrepared($sql, [$status]);
        return $result->fetch_assoc()['total'];
    }

    public function getPhieuNhapById($id) {
        $sql = "SELECT * FROM phieunhap WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

}
?>