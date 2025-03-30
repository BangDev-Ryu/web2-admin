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
        return $this->db->selectAll('theloai');
    }

    public function getNameById($id) {
        $sql = "SELECT name FROM theloai WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['name'];
    }

    public function getTheLoais($limit, $offset) {
        $sql = "SELECT * FROM theloai
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTheLoaiById($id) {
        $sql = "SELECT * FROM theloai WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
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

}
?>