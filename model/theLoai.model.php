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

}
?>