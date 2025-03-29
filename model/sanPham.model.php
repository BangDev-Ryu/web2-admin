<?php
require_once '../model/connect.php';

class SanPhamModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalSanPhams() {
        return $this->db->totalByCondition('sanpham', '', '1=1', []);
    }

    public function getSanPhams($limit, $offset) {
        $sql = "SELECT * FROM sanpham
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

}
?>