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

    // public function getTrangThaiById($id) {
    //     $sql = "SELECT * FROM trangthai WHERE id = ?";
    //     return $this->db->executePrepared($sql, [$id]);
    // }

    // public function addTrangThai($ten) {
    //     $sql = "INSERT INTO trangthai (ten) VALUES (?)";
    //     return $this->db->executePrepared($sql, [$ten]);
    // }

    // public function updateTrangThai($id, $ten) {
    //     $sql = "UPDATE trangthai SET ten = ? WHERE id = ?";
    //     return $this->db->executePrepared($sql, [$ten, $id]);
    // }

    // public function deleteTrangThai($id) {
    //     $sql = "DELETE FROM trangthai WHERE id = ?";
    //     return $this->db->executePrepared($sql, [$id]);
    // }
}
?>