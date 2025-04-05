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

    public function getSanPhamById($id) {
        $sql = "SELECT * FROM sanpham WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

    public function addSanPham($data) {
        $sql = "INSERT INTO sanpham (
                    name, 
                    description, 
                    selling_price, 
                    stock_quantity, 
                    theloai_id, 
                    trangthai_id, 
                    warranty_days, 
                    image_url, 
                    updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['selling_price'],
            $data['stock_quantity'],
            $data['theloai_id'],
            $data['trangthai_id'],
            $data['warranty_days'],
            $data['image_url'],
            $data['updated_at']
        ]);
    }

    public function updateSanPham($data) {
        $sql = "UPDATE sanpham SET 
                    name = ?, 
                    description = ?, 
                    selling_price = ?, 
                    stock_quantity = ?, 
                    theloai_id = ?, 
                    trangthai_id = ?, 
                    warranty_days = ?, 
                    image_url = ?, 
                    updated_at = ?
                WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['selling_price'],
            $data['stock_quantity'],
            $data['theloai_id'],
            $data['trangthai_id'],
            $data['warranty_days'],
            $data['image_url'],
            $data['updated_at'],
            $data['id']
        ]);
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

    public function filterSanPham($filter, $limit, $offset) {
        $sql = "SELECT * FROM sanpham 
                WHERE trangthai_id = ? AND theloai_id = ?
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$filter['trangthai_id'], $filter['theloai_id'], $limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getTotalFilterSanPham($filter) {
        $sql = "SELECT COUNT(*) as total FROM sanpham 
                WHERE trangthai_id = ? AND theloai_id = ?";
        $result = $this->db->executePrepared($sql, [$filter['trangthai_id'], $filter['theloai_id']]);
        return $result->fetch_assoc()['total'];
    }
}
?>