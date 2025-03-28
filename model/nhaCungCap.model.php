<?php
require_once '../model/connect.php';

class NhaCungCapModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalNhaCungCaps() {
        return $this->db->totalByCondition('nhacungcap', '', '1=1', []);
    }

    public function getNhaCungCaps($limit, $offset) {
        $sql = "SELECT * FROM nhacungcap
                LIMIT ? OFFSET ?";
        return $this->db->executePrepared($sql, [$limit, $offset]);
    }

}
?>