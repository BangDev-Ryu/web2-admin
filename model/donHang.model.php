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
    
    public function getCTDonHangById($id) {
        $sql = "SELECT * FROM chitietphieuban WHERE phieuban_id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatusDonHang($id, $status) {
        $sql = "UPDATE phieuban SET trangthai_id = ? WHERE id = ?";
        return $this->db->executePrepared($sql, [$status, $id]);
    }

    public function getDonHangStatus($id) {
        $sql = "SELECT trangthai_id FROM phieuban WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        if ($row = $result->fetch_assoc()) {
            return $row['trangthai_id'];
        }
        return null;
    }

    public function getTop5NguoiDungs($startDate, $endDate) {
        $sql = "SELECT p.nguoidung_id as id, SUM(p.total_amount) as total_spending 
                FROM phieuban p
                WHERE DATE(p.order_date) BETWEEN ? AND ?
                AND p.trangthai_id = 9
                GROUP BY p.nguoidung_id
                ORDER BY total_spending DESC
                LIMIT 5";
                
        $result = $this->db->executePrepared($sql, [$startDate, $endDate]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getDonHangNguoiDung($nguoiDungId, $startDate, $endDate) {
        $sql = "SELECT p.*, COALESCE(k.name, 'Không có') as khuyenmai_name 
                FROM phieuban p 
                LEFT JOIN khuyenmai k ON p.khuyenmai_id = k.id
                WHERE p.nguoidung_id = ? 
                AND DATE(p.order_date) BETWEEN ? AND ?
                AND p.trangthai_id = 9
                ORDER BY p.order_date DESC";
        
        $result = $this->db->executePrepared($sql, [$nguoiDungId, $startDate, $endDate]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>