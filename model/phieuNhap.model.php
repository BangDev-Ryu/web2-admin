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

    public function addPhieuNhap($data) {
        $sql = "INSERT INTO phieunhap (nhacungcap_id, nguoidung_id, date, trangthai_id, total_amount) 
                VALUES (?, ?, ?, ?, ?)";
        
        return $this->db->executePrepared($sql, [
            $data['nhacungcap_id'],
            $data['nguoidung_id'],
            $data['date'],
            $data['trangthai_id'],
            $data['total_amount']
        ]);
    }

    public function getLastInsertId() {
        $sql = "SELECT id FROM phieunhap ORDER BY id DESC LIMIT 1";
        $result = $this->db->executePrepared($sql, []);
        return $result->fetch_assoc()['id'];
    }

    public function addChiTietPhieuNhap($data) {
        $sql = "INSERT INTO chitietphieunhap (phieunhap_id, sanpham_id, quantity, price, profit) 
                VALUES (?, ?, ?, ?, ?)";
                
        return $this->db->executePrepared($sql, [
            $data['phieunhap_id'],
            $data['sanpham_id'], 
            $data['quantity'],
            $data['price'],
            $data['profit']
        ]);
    }

}
?>