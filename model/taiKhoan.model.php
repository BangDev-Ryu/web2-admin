<?php
require_once '../model/connect.php';

class TaiKhoanModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getTotalTaiKhoans() {
        return $this->db->totalByCondition('taikhoan', '', 'trangthai_id IN (1,3)', []);
    }

    public function getAllTaiKhoans() {
        return $this->db->selectAll('taikhoan');
    }

    public function getTaiKhoanById($id) {
        $sql = "SELECT 
                    taikhoan.id ,
                    taikhoan.username,
                    taikhoan.password,
                    taikhoan.type_account,
                    taikhoan.created_at,
                    taikhoan.trangthai_id,
                    nguoidung.fullname,
                    nguoidung.email,
                    nguoidung.phone,
                    nguoidung.date_of_birth,
                    nguoidung.chucvu_id,
                    nguoidung.picture 
                FROM taikhoan
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                WHERE taikhoan.id = ?";
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
                    taikhoan.id ,
                    taikhoan.username,
                    taikhoan.type_account,
                    taikhoan.created_at,
                    taikhoan.trangthai_id,
                    nguoidung.fullname,
                    nguoidung.email,
                    nguoidung.phone,
                    nguoidung.date_of_birth,
                    nguoidung.chucvu_id,
                    nguoidung.picture
                FROM taikhoan
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                WHERE taikhoan.trangthai_id IN (1,3)
                ORDER BY taikhoan.id
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addTaiKhoan($data) {
        if (isset($data['img'])) {
            $newId = $this->getLastId() + 1; // lấy id mới nhất
            $ext = pathinfo($data['img']['name'], PATHINFO_EXTENSION); // lấy đuôi file
            $targetDir = __DIR__ . "/../assets/img/user-img/"; // tạo đường dẫn
            $targetFile = $targetDir . "user_" . $newId . "." . $ext; // đường dẫn hoàn chỉnh

            move_uploaded_file($data["img"]["tmp_name"], $targetFile); // 
            $picture = "./assets/img/user-img/user_" . $newId . "." . $ext; // đường dẫn hoàn chỉnh
            $data['picture'] = $picture; 
        } else {
            // Sử dụng ảnh mặc định nếu không có ảnh được tải lên
            $data['picture'] = "./assets/img/user-img/user_default.png";
        }
        $hashed_password = password_hash($data["password"], PASSWORD_BCRYPT);
        $sql = "INSERT INTO taikhoan (username, password, trangthai_id, type_account, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
            $resultAddAccount = $this->db->executePrepared($sql, [$data['username'], $hashed_password, 1, $data['type_account']]);
        if ($resultAddAccount) {
            $taikhoan_id = $this->getLastId();
            $sql = "INSERT INTO nguoidung (taikhoan_id, fullname, email, phone, date_of_birth, chucvu_id, picture) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            return $this->db->executePrepared($sql, [$taikhoan_id, $data['fullname'], $data['email'], $data['phone'], $data['date_of_birth'], $data['chucvu_id'], $data['picture']]);
            
        }
        return false;
}
public function updateTaiKhoan($data) {
    if (isset($data['img'])) {
        $ext = pathinfo($data['img']['name'], PATHINFO_EXTENSION);
        $targetDir = __DIR__ . "/../assets/img/user-img/";
        $targetFile = $targetDir . "user_" . $data['id'] . "." . $ext;

        move_uploaded_file($data["img"]["tmp_name"], $targetFile);
        $picture = "./assets/img/user-img/user_" . $data['id'] . "." . $ext;
        $data['picture'] = $picture;
    }

    // Tạo câu SQL cơ bản không có password
    $sql = "UPDATE taikhoan SET username = ?, type_account = ? WHERE id = ?";
    $params = [$data['username'],  $data['type_account'], $data['id']];

    // Nếu có password mới thì thêm vào câu SQL
    if (isset($data["password"]) && $data["password"] !== "") {
        $hashed_password = password_hash($data["password"], PASSWORD_BCRYPT);
        $sql = "UPDATE taikhoan 
                SET username = ?, type_account = ?, password = ?
                WHERE id = ?";
        $params = [
            $data['username'], 
            $data['type_account'],
            $hashed_password,
            $data['id']
        ];
    }
    
    $resultUpdateAccount = $this->db->executePrepared($sql, $params);
    if ($resultUpdateAccount) {
        $sql = "UPDATE nguoidung 
                SET fullname = ?, email = ?, phone = ?, date_of_birth = ?, chucvu_id = ?, picture = ? 
                WHERE taikhoan_id = ?";
        return $this->db->executePrepared($sql, [
            $data['fullname'], 
            $data['email'], 
            $data['phone'], 
            $data['date_of_birth'], 
            $data['chucvu_id'], 
            $data['picture'], 
            $data['id']
        ]);
    }
    return false;
}

    public function checkExistInPhieu($id) {
        $sql = "SELECT COUNT(*) as total 
                FROM (
                    SELECT nguoidung_id 
                    FROM phieuban 
                    WHERE nguoidung_id = (
                        SELECT nguoidung.id 
                        FROM nguoidung 
                        WHERE nguoidung.taikhoan_id = ?
                    )
                    UNION 
                    SELECT nguoidung_id 
                    FROM phieunhap 
                    WHERE nguoidung_id = (
                        SELECT nguoidung.id 
                        FROM nguoidung 
                        WHERE nguoidung.taikhoan_id = ?
                    )
                ) AS combined_checks";
        $result = $this->db->executePrepared($sql, [$id, $id]);
        return $result->fetch_assoc()['total'] > 0;
    }

    public function hideTaiKhoan($id) {
        $sql = "UPDATE taikhoan SET trangthai_id = 2 WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }

    public function deleteTaiKhoan($id) {
        $sqlDeleteNguoiDung = "DELETE FROM nguoidung WHERE taikhoan_id = ?";
        $resultDeleteNguoiDung = $this->db->executePrepared($sqlDeleteNguoiDung, [$id]);
        
        if ($resultDeleteNguoiDung) {
            $sqlDeleteTaiKhoan = "DELETE FROM taikhoan WHERE id = ?";
            return $this->db->executePrepared($sqlDeleteTaiKhoan, [$id]);
        }
        return false;
    }

    public function lockTaiKhoan($id) {
        $sql = "UPDATE taikhoan SET trangthai_id = 3 WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }

    public function unlockTaiKhoan($id) {
        $sql = "UPDATE taikhoan SET trangthai_id = 1 WHERE id = ?";
        return $this->db->executePrepared($sql, [$id]);
    }
    
    public function getLastId() {
        $sql = "SELECT id FROM taikhoan ORDER BY id DESC LIMIT 1";
        $result = $this->db->executePrepared($sql, []);
        return $result->fetch_assoc()['id'];
    }


    public function getTotalSearchTaiKhoan($search) {
        $sql = "SELECT COUNT(*) as total 
                FROM taikhoan 
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                WHERE (taikhoan.id LIKE ? 
                    OR LOWER(taikhoan.username) LIKE ? 
                    OR LOWER(nguoidung.fullname) LIKE ? 
                    OR LOWER(nguoidung.email) LIKE ?)
                AND taikhoan.trangthai_id IN (1,3)";
        
        $searchParam = '%' . strtolower($search) . '%';
        $params = array_fill(0, 4, $searchParam);
        
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }

    public function searchTaiKhoan($search, $limit, $offset) {
        $sql = "SELECT 
                taikhoan.id,
                taikhoan.username,
                taikhoan.type_account,
                taikhoan.created_at,
                taikhoan.trangthai_id,
                nguoidung.fullname,
                nguoidung.email,
                nguoidung.phone,
                nguoidung.date_of_birth,
                nguoidung.chucvu_id,
                nguoidung.picture
                FROM taikhoan 
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                WHERE (taikhoan.id LIKE ? 
                    OR LOWER(taikhoan.username) LIKE ? 
                    OR LOWER(nguoidung.fullname) LIKE ? 
                    OR LOWER(nguoidung.email) LIKE ?)
                AND taikhoan.trangthai_id IN (1,3)
                LIMIT ? OFFSET ?";
    
        $searchParam = '%' . strtolower($search) . '%';
        $params = array_fill(0, 4, $searchParam);
        $params[] = $limit;
        $params[] = $offset;
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function filterTaiKhoan($filter, $limit, $offset) {
        $sql = "SELECT taikhoan.*, nguoidung.* 
                FROM taikhoan 
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                WHERE taikhoan.trangthai_id IN (1,3)";
    
        $params = [];
    
        if (isset($filter['trangthai_id']) && $filter['trangthai_id'] !== "") {
            $sql .= " AND taikhoan.trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }
    
        if (isset($filter['type_account']) && $filter['type_account'] !== "") {
            $sql .= " AND taikhoan.type_account = ?";
            $params[] = $filter['type_account'];
        }
    
        if (isset($filter['chucvu_id']) && $filter['chucvu_id'] !== "") {
            $sql .= " AND nguoidung.chucvu_id = ?";
            $params[] = $filter['chucvu_id'];
        }
    
        $sql .= " ORDER BY taikhoan.id LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalFilterTaiKhoan($filter) {
        $sql = "SELECT COUNT(*) as total 
                FROM taikhoan 
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                WHERE 1 = 1";
    
        $params = [];
    
        if (!empty($filter['trangthai_id'])) {
            $sql .= " AND taikhoan.trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }
    
        if (!empty($filter['type_account'])) {
            $sql .= " AND taikhoan.type_account = ?";
            $params[] = $filter['type_account'];
        }
    
        if (!empty($filter['chucvu_id'])) {
            $sql .= " AND nguoidung.chucvu_id = ?";
            $params[] = $filter['chucvu_id'];
        }
    
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }

    public function checkEmailExists($email, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM nguoidung WHERE email = ?";
        $params = [$email];
        
        if ($excludeId) {
            $sql .= " AND taikhoan_id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['count'] > 0;
    }

    public function checkUsernameExists($username, $excludeId = null) {
        $sql = "SELECT COUNT(*) as count FROM taikhoan WHERE username = ?";
        $params = [$username];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['count'] > 0;
    }

    public function validateDateOfBirth($date) {
        $birthDate = new DateTime($date);
        $today = new DateTime();
        
        return $birthDate <= $today;
    }

    public function checkLogin($username, $password) {
        $sql = "SELECT taikhoan.*, nguoidung.chucvu_id 
                FROM taikhoan 
                LEFT JOIN nguoidung ON taikhoan.id = nguoidung.taikhoan_id
                WHERE username = ?";
                
        $result = $this->db->executePrepared($sql, [$username])->fetch_assoc();

        $message = '';

        if ($result['type_account'] != 0) {
            return [
                'success' => false,
                'message' => 'Tài khoản không phải là tài khoản quản trị'
            ];
            
        }

        if ($result['trangthai_id'] == 3) {
            return [
                'success' => false,
                'message' => 'Tài khoản đã bị khóa'
            ];
        }
        
        if ($result) {
            // Kiểm tra mật khẩu
            if (password_verify($password, $result['password'])) {
                // Kiểm tra trạng thái tài khoản
                if ($result['trangthai_id'] == 1) { 
                    return [
                        'success' => true,
                        'id' => $result['id'],
                        'role_id' => $result['chucvu_id'] 
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Tài khoản đã bị khóa'
                    ];
                }
            }
        }
        
        return [
            'success' => false,
            'message' => $message
        ];
    }


}
?>