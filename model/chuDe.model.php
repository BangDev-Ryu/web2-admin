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

    public function getAllChuDes() {
        $result = $this->db->selectAll('chude');
        return $result->fetch_all(MYSQLI_ASSOC);
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
        $sql = "INSERT INTO chude (name, description, trangthai_id) VALUES (?, ?, ?)";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['trangthai_id']
        ]);
    }

    public function updateChuDe($data) {
        $sql = "UPDATE chude SET name = ?, description = ?, trangthai_id = ? WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['trangthai_id'],
            $data['id']
        ]);
    }

    public function deleteChuDe($id) {
        $sql = "DELETE FROM chude WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }

    public function searchChuDe($search) {
        $sql = "SELECT cd.*, tt.name as trangthai_name 
                FROM chude cd
                LEFT JOIN trangthai tt ON cd.trangthai_id = tt.id
                WHERE cd.id LIKE ? OR LOWER(cd.name) LIKE ?";
        $searchParam = "%$search%";
        $result = $this->db->executePrepared($sql, [$searchParam, $searchParam]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>