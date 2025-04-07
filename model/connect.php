<?php
class connectDB
{
    private $servername = "localhost";
    private $username = "root";
    private $databasename = "web2_sql";
    private $password = "";
    public $conn; // Thuộc tính chứa kết nối

    public function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->databasename);
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }

    // Thực hiện câu lệnh đã chuẩn bị
    public function executePrepared($sql, $params)
    {
        $stmt = $this->conn->prepare($sql);
        if ($stmt === false) {
            die("Lỗi chuẩn bị truy vấn: " . $this->conn->error);
        }

        // Bind các tham số
        if ($params) {
            $types = '';
            foreach ($params as $param) {
                $types .= is_int($param) ? 'i' : 's'; // 'i' cho số nguyên, 's' cho chuỗi
            }
            $stmt->bind_param($types, ...$params);
        }

        // Thực hiện truy vấn
        if ($stmt->execute()) {
            // Nếu là câu lệnh SELECT, trả về kết quả
            if (stripos($sql, 'SELECT') === 0) {
                return $stmt->get_result();
            }
            return true; // Nếu là INSERT, UPDATE, DELETE
        } else {
            die("Lỗi thực thi truy vấn: " . $stmt->error);
        }
    }

    // Đóng kết nối
    public function close()
    {
        $this->conn->close();
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    // Lấy tất cả bản ghi từ bảng
    public function selectAll($tableName)
    {
        $sql = "SELECT * FROM $tableName";
        return $this->query($sql);
    }

    // Lấy bản ghi theo điều kiện
    public function selectByCondition($tableName, $condition, $params)
    {
        $sql = "SELECT * FROM $tableName WHERE $condition";
        return $this->executePrepared($sql, $params);
    }

    // Lấy tổng số dòng bản ghi theo điều kiện với JOIN
    public function totalByCondition($tableName, $join = '', $condition, $params) {
    // Sử dụng COUNT(*) để đếm tổng số dòng
        $sql = "SELECT COUNT(*) AS total FROM $tableName $join WHERE $condition";
        
        $result = $this->executePrepared($sql, $params);
        
        if ($result instanceof mysqli_result) {
            $row = $result->fetch_assoc();
            return (int) $row['total'];
        }
        
        return 0; // Trả về 0 nếu không có kết quả
    }

    public function getLastInsertId() {
        return $this->conn->insert_id;
    }
}
?>