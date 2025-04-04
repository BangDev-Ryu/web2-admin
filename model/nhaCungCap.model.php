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

    public function getNameById($id) {
        $sql = "SELECT name FROM nhacungcap WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['name'];
    }


    public function getNhaCungCaps($limit, $offset) {
        $sql = "SELECT * FROM nhacungcap
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNhaCungCapById($id) {
        $sql = "SELECT * FROM nhacungcap WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

    public function addNhaCungCap($data) {
        $sql = "INSERT INTO nhacungcap (name, contact_person, contact_email, contact_phone, address, trangthai_id) VALUES (?, ?, ?, ?, ? , ?)";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['contact_person'],
            $data['contact_email'],
            $data['contact_phone'],
            $data['address'],
            $data['trangthai_id']
        ]);
    }

    public function updateNhaCungCap($data) {
        $sql = "UPDATE nhacungcap SET name = ?, contact_person = ?, contact_email = ?, contact_phone = ?, address = ?, trangthai_id = ? WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['contact_person'],
            $data['contact_email'],
            $data['contact_phone'],
            $data['address'],
            $data['trangthai_id'],
            $data['id']
        ]);
    }

    public function deleteNhaCungCap($id) {
        $sql = "DELETE FROM nhacungcap WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }

    public function searchNhaCungCap($search) {
        $sql = "SELECT * FROM nhacungcap 
                WHERE id LIKE ? 
                OR LOWER(name) LIKE ? 
                OR LOWER(contact_person) LIKE ? 
                OR LOWER(contact_email) LIKE ? 
                OR LOWER(contact_phone) LIKE ? 
                OR LOWER(address) LIKE ?";
        
        $searchParam = "%" . strtolower($search) . "%";
        $result = $this->db->executePrepared($sql, [
            $searchParam, $searchParam, $searchParam,
            $searchParam, $searchParam, $searchParam
        ]);
        
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    


}
?>