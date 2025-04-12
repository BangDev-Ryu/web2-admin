<?php
require_once '../model/connect.php';

class ChuDeModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalChuDes() {
        return $this->db->totalByCondition('chude', '', '1=1', []);
    }

    public function getNameById($id) {
        $sql = "SELECT name FROM chude WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['name'];
    }

    public function getChuDes($limit, $offset) {
        $sql = "SELECT * FROM chude
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getChuDeById($id) {
        $sql = "SELECT * FROM chude WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

    public function addChuDe($data) {
        $sql = "INSERT INTO chude (name, theloai_id, trangthai_id) VALUES (?, ?, ?)";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['theloai_id'],
            $data['trangthai_id']
        ]);
    }

    public function updateChuDe($data) {
        $sql = "UPDATE chude SET name = ?, theloai_id = ?, trangthai_id = ? WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['theloai_id'],
            $data['trangthai_id'],
            $data['id']
        ]);
    }

    public function deleteChuDe($id) {
        $sql = "DELETE FROM chude WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }

    public function searchNhaCungCap($search, $limit, $offset) {
        $sql = "SELECT * FROM nhacungcap 
                WHERE id LIKE ? 
                OR LOWER(name) LIKE ? 
                OR LOWER(contact_person) LIKE ? 
                OR LOWER(contact_email) LIKE ? 
                OR LOWER(contact_phone) LIKE ? 
                OR LOWER(address) LIKE ?
                LIMIT ? OFFSET ?";
    
        $searchParam = "%$search%";
        $params = array_fill(0, 6, $searchParam); 
        $params[] = $limit;
        $params[] = $offset;
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);

    } public function searchChuDe($search, $limit, $offset) {
        $sql = "SELECT * FROM chude 
                WHERE id LIKE ? 
                OR LOWER(name) LIKE ? 
                LIMIT ? OFFSET ?";
    
        $searchParam = "%$search%";
        $params = array_fill(0, 2, $searchParam); 
        $params[] = $limit;
        $params[] = $offset;
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalSearchChuDe($search) {
        $sql = "SELECT COUNT(*) as total FROM chude 
                WHERE id LIKE ? OR LOWER(name) LIKE ?";
        $searchParam = "%$search%";
        $params = array_fill(0, 2, $searchParam); 
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }


    public function filterChuDe($filter, $limit, $offset) {
        $sql = "SELECT * FROM chude";
        $conditions = [];
        $params = [];
    
        if (!empty($filter['trangthai_id'])) {
            $conditions[] = "trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }
    
        if (!empty($filter['theloai_id'])) { 
            $conditions[] = "theloai_id = ?";
            $params[] = $filter['theloai_id'];
        }
    
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    public function getTotalFilterChuDe($filter) {
        $sql = "SELECT COUNT(*) as total FROM chude";
        $conditions = [];
        $params = [];
    
        if (!empty($filter['trangthai_id'])) {
            $conditions[] = "trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }
    
        if (!empty($filter['theloai_id'])) {
            $conditions[] = "theloai_id = ?";
            $params[] = $filter['theloai_id'];
        }
    
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }
    
}
?>