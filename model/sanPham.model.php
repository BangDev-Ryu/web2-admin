<?php
require_once '../model/connect.php';

class SanPhamModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalProducts() {
        return $this->db->totalByCondition('sanpham', '', '1=1', []);
    }

    public function getProducts($limit, $offset) {
        $sql = "SELECT * FROM sanpham
                LIMIT ? OFFSET ?";
        return $this->db->executePrepared($sql, [$limit, $offset]);
    }

}
?>