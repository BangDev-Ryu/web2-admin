<?php
require_once '../model/connect.php';

class ChucVuModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalChucVus() {
        return $this->db->totalByCondition('chucvu', '', '1=1', []);
    }

    public function getAllChucVus() {
        $result = $this->db->selectAll("chucvu");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getChucVus($limit, $offset) {
        $sql = "SELECT * FROM chucvu
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNameById($id) {
        $sql = "SELECT role_name FROM chucvu WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['role_name'];
    }

    public function getChucVuById($id) {
        $sql = "SELECT * FROM chucvu WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

    public function getLastId() {
        $sql = "SELECT id FROM chucvu ORDER BY id DESC LIMIT 1";
        $result = $this->db->executePrepared($sql, []);
        return $result->fetch_assoc()['id'];
    }

    public function addChucVu($data) {
        $sql = "INSERT INTO chucvu (role_name, role_description) VALUES (?, ?)";
        $resultChucVu = $this->db->executePrepared($sql, [$data['role_name'], $data['role_description']]);

        if ($resultChucVu) {
            $chucVuId = $this->getLastId();
            foreach ($data['quyens'] as $quyenId) {
                $sql = "INSERT INTO chitietphanquyen (chucvu_id, quyen_id) VALUES (?, ?)";
                $this->db->executePrepared($sql, [$chucVuId, $quyenId]);
            }
        }
    }

    public function getQuyensByChucVu($id) {
        $sql = "SELECT quyen_id FROM chitietphanquyen WHERE chucvu_id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateChucVu($data) {
        $sql = "UPDATE chucvu SET role_name = ?, role_description = ? WHERE id = ?";
        $resultChucVu = $this->db->executePrepared($sql, [
            $data['role_name'],
            $data['role_description'],
            $data['id']
        ]);

        if ($resultChucVu) {
            $sql = "DELETE FROM chitietphanquyen WHERE chucvu_id = ?";
            $this->db->executePrepared($sql, [$data['id']]);

            // Thêm các quyền mới
            foreach ($data['quyens'] as $quyenId) {
                $sql = "INSERT INTO chitietphanquyen (chucvu_id, quyen_id) VALUES (?, ?)";
                $this->db->executePrepared($sql, [$data['id'], $quyenId]);
            }
            return true;
        }
        
    }
}
?>