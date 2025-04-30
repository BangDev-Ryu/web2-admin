<?php
require_once '../model/connect.php';

class TheLoaiModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalTheLoais() {
        return $this->db->totalByCondition('theloai', '', '1=1', []);
    }

    public function getAllTheLoais() {
        $result = $this->db->selectAll('theloai');
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNameById($id) {
        $sql = "SELECT name FROM theloai WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['name'];
    }

    public function getTheLoaiById($id) {
        $sql = "SELECT * FROM theloai WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }


    public function getTheLoais($limit, $offset) {
        $sql = "SELECT * FROM theloai
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addTheLoai($data) {
        $sql = "INSERT INTO theloai (name, description, trangthai_id) VALUES (?, ?, ?)";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['trangthai_id']
        ]);
    }

    public function updateTheLoai($data) {
        $sql = "UPDATE theloai SET name = ?, description = ?, trangthai_id = ? WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['trangthai_id'],
            $data['id']
        ]);
    }

    public function deleteTheLoai($id) {
        $sql = "DELETE FROM theloai WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }

    public function searchTheLoai($search, $limit, $offset) {
        $sql = "SELECT * FROM theloai 
                WHERE id LIKE ? OR LOWER(name) LIKE ? 
                OR LOWER(description) LIKE ?
                LIMIT ? OFFSET ?";
        $searchParam = "%$search%";
        $params = array_fill(0, 3, $searchParam); 
        $params[] = $limit;
        $params[] = $offset;
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);

    }

    public function getTotalSearchTheLoai($search) {
        $sql = "SELECT COUNT(*) as total FROM theloai 
                WHERE id LIKE ? OR LOWER(name) LIKE ? 
                OR LOWER(description) LIKE ?";
        $searchParam = "%$search%";
        $params = array_fill(0, 3, $searchParam); 
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];

    }

    public function filterTheLoai($filter, $limit, $offset) {
        $sql = "SELECT * FROM theloai";
        $params = [];
    
        if (!empty($filter['trangthai_id'])) {
            $sql .= " WHERE trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }
    
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    
    public function getTotalFilterTheLoai($filter) {
        $sql = "SELECT COUNT(*) as total FROM theloai";
        $params = [];
    
        if (!empty($filter['trangthai_id'])) {
            $sql .= " WHERE trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }
    
    }

?>