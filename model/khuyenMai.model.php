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

    public function getTotalSearchKhuyenMai($search) {
        $sql = "SELECT COUNT(*) as total FROM khuyenmai
                WHERE id LIKE ? 
            OR LOWER(name) LIKE ?
            OR LOWER(code) LIKE ? 
            OR profit LIKE ? 
            OR type LIKE ? 
            OR startDate LIKE ?
            OR endDate LIKE ?";
    
        $searchParam = "%$search%";
        $params = array_fill(0, 7, $searchParam); 
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }

    public function searchKhuyenMai($search, $limit, $offset) {
        $sql = "SELECT * FROM khuyenmai
                WHERE id LIKE ? 
                OR LOWER(name) LIKE ? 
                OR LOWER(code) LIKE ? 
                OR profit LIKE ? 
                OR type LIKE ? 
                OR startDate LIKE ?
                OR endDate LIKE ?
                LIMIT ? OFFSET ?";
    
        $searchParam = "%$search%";
        $params = array_fill(0, 7, $searchParam); 
        $params[] = $limit;
        $params[] = $offset;
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function filterKhuyenMai($filter, $limit, $offset) {
        $sql = "SELECT * FROM khuyenmai 
            WHERE profit BETWEEN ? AND ?";

        $params = [
            $filter['min_Profit'],
            $filter['max_Profit']
        ];

        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalFilterKhuyenMai($filter) {
        $sql = "SELECT COUNT(*) as total FROM khuyenmai 
                WHERE profit BETWEEN ? AND ?";

    $params = [
        $filter['min_Profit'],
        $filter['max_Profit']
    ];

        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }
}
    

?>