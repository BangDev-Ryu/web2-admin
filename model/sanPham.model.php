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

    public function getTotalSearchSanPham($search) {
        $sql = "SELECT COUNT(*) as total FROM sanpham 
                WHERE id LIKE ? OR LOWER(name) LIKE ?";
        $searchParam = "%$search%";
        $result = $this->db->executePrepared($sql, [$searchParam, $searchParam]);
        return $result->fetch_assoc()['total'];
    }

    public function searchSanPham($search, $limit, $offset) {
        $sql = "SELECT * FROM sanpham 
                WHERE id LIKE ? OR LOWER(name) LIKE ?
                LIMIT ? OFFSET ?";
        $searchParam = "%$search%";
        $result = $this->db->executePrepared($sql, [$searchParam, $searchParam, $limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>