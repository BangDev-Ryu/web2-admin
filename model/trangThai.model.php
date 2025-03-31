<?php
require_once '../model/connect.php';

class TrangThaiModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalTrangThais() {
        return $this->db->totalByCondition('trangthai', '', '1=1', []);
    }

    public function getAllTrangThais() {
        $result = $this->db->selectAll("trangthai");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNameById($id) {
        $sql = "SELECT name FROM trangthai WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['name'];
    }

    public function getTrangThaiByType($limit, $offset) {
        $sql = "SELECT * FROM trangthai
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>