<?php
require_once '../model/connect.php';

class KhuyenMaiModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalKhuyenMais() {
        return $this->db->totalByCondition('khuyenmai', '', '1=1', []);
    }

    public function getNameById($id) {
        $sql = "SELECT name FROM khuyenmai WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['name'];
    }


    public function getKhuyenMais($limit, $offset) {
        $sql = "SELECT * FROM khuyenmai
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getKhuyenMaiById($id) {
        $sql = "SELECT * FROM khuyenmai WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

    public function addKhuyenMai($data) {
        $sql = "INSERT INTO khuyenmai (name, code, profit, type, startDate, endDate) VALUES (?, ?, ?, ?, ? , ?)";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['code'],
            $data['profit'],
            $data['type'],
            $data['startDate'],
            $data['endDate']
        ]);
    }

    public function updateKhuyenMai($data) {
        $sql = "UPDATE khuyenmai SET name = ?, code = ?, profit = ?, type = ?, startDate = ?, endDate = ? WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['code'],
            $data['profit'],
            $data['type'],
            $data['startDate'],
            $data['endDate'],
            $data['id']
        ]);
    }

    public function deleteKhuyenMai($id) {
        $sql = "DELETE FROM khuyenmai WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }

    public function searchKhuyenMai($search) {
        $sql = "SELECT * FROM khuyenmai
                WHERE id LIKE ? 
                OR LOWER(name) LIKE ? 
                OR LOWER(code) LIKE ? 
                OR profit LIKE ? 
                OR type LIKE ? 
                OR startDate LIKE ?
                OR endDate LIKE ?";
        
        $searchParam = "%" . strtolower($search) . "%";
        $result = $this->db->executePrepared($sql, [
            $searchParam, $searchParam, $searchParam,
            $searchParam, $searchParam, $searchParam,
            $searchParam
        ]);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    


}
?>