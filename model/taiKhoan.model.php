<?php
require_once '../model/connect.php';

class TaiKhoanModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalTaiKhoans() {
        return $this->db->totalByCondition('taikhoan', '', '1=1', []);
    }

    public function getAllTaiKhoans() {
        return $this->db->selectAll('taikhoan');
    }

    public function getTaiKhoanById($id) {
        $sql = "SELECT * FROM taikhoan WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

    public function getUserNameById($id) {
        $sql = "SELECT username FROM taikhoan WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc()['username'];
    }

    public function getTaiKhoans($limit, $offset) {
        $sql = "SELECT 
                    taikhoan.id AS taiKhoan_id,
                    taikhoan.username,
                    taikhoan.type_account,
                    taikhoan.created_at,
                    taikhoan.trangthai_id,
                    nguoidung.fullname,
                    nguoidung.email,
                    nguoidung.phone,
                    nguoidung.date_of_birth,
                    nguoidung.picture
                FROM taikhoan
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addTaiKhoan($username, $password, $trangthai_id, $type_account) {
        $sql = "INSERT INTO taikhoan (username, password, trangthai_id, type_account, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        return $this->db->executePrepared($sql, [
            $username,
            password_hash($password, PASSWORD_BCRYPT), // Mã hóa mật khẩu
            $trangthai_id,
            $type_account
        ]);
    }

    public function updateTaiKhoan($id, $username, $password, $trangthai_id, $type_account) {
        $sql = "UPDATE taikhoan 
                SET username = ?, password = ?, trangthai_id = ?, type_account = ? 
                WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $username,
            password_hash($password, PASSWORD_BCRYPT), // Mã hóa mật khẩu
            $trangthai_id,
            $type_account,
            $id
        ]);
    }

    public function deleteTaiKhoan($id) {
        $sql = "DELETE FROM taikhoan WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }
}
?>