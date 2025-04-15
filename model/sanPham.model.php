<?php
require_once '../model/connect.php';

class SanPhamModel {
    private $db;

    public function __construct() {
        $this->db = new connectDB();
    }

    public function getAllSanPhams() {
        $sql = "SELECT * FROM sanpham";
        $result = $this->db->executePrepared($sql, []);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalSanPhams() {
        return $this->db->totalByCondition('sanpham', '', '1=1', []);
    }

    public function getSanPhams($limit, $offset) {
        $sql = "SELECT * FROM sanpham
                LIMIT ? OFFSET ?";
        $result = $this->db->executePrepared($sql, [$limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getSanPhamById($id) {
        $sql = "SELECT * FROM sanpham WHERE id = ?";
        $result = $this->db->executePrepared($sql, [$id]);
        return $result->fetch_assoc();
    }

    public function getLastId() {
        $sql = "SELECT id FROM sanpham ORDER BY id DESC LIMIT 1";
        $result = $this->db->executePrepared($sql, []);
        return $result->fetch_assoc()['id'];
    }

    public function addSanPham($data) {
        if (isset($data['img'])) {
            $newId = $this->getLastId() + 1; // lấy id mới nhất
            $ext = pathinfo($data['img']['name'], PATHINFO_EXTENSION); // lấy đuôi file
            $targetDir = __DIR__ . "/../assets/img/product-img/"; // tạo đường dẫn
            $targetFile = $targetDir . "product_" . $newId . "." . $ext; // đường dẫn hoàn chỉnh

            move_uploaded_file($data["img"]["tmp_name"], $targetFile); // 
            $image_url = "./assets/img/product-img/product_" . $newId . "." . $ext; // đường dẫn hoàn chỉnh
            $data['image_url'] = $image_url; 
        } 

        $sql = "INSERT INTO sanpham (
                    name, 
                    description, 
                    selling_price, 
                    stock_quantity, 
                    chude_id, 
                    trangthai_id, 
                    warranty_days, 
                    image_url, 
                    updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['selling_price'],
            $data['stock_quantity'],
            $data['chude_id'],
            $data['trangthai_id'],
            $data['warranty_days'],
            $data['image_url'],
            $data['updated_at']
        ]);
    }

    public function updateSanPham($data) {
        if (isset($data['img'])) {
            $ext = pathinfo($data['img']['name'], PATHINFO_EXTENSION); // lấy đuôi file
            $targetDir = __DIR__ . "/../assets/img/product-img/"; // tạo đường dẫn
            $targetFile = $targetDir . "product_" . $data['id'] . "." . $ext; // đường dẫn hoàn chỉnh

            move_uploaded_file($data["img"]["tmp_name"], $targetFile); 
            $image_url = "./assets/img/product-img/product_" . $data['id'] . "." . $ext; // đường dẫn hoàn chỉnh
            $data['image_url'] = $image_url; 
        } 

        $sql = "UPDATE sanpham SET 
                    name = ?, 
                    description = ?, 
                    selling_price = ?, 
                    stock_quantity = ?, 
                    chude_id = ?, 
                    trangthai_id = ?, 
                    warranty_days = ?, 
                    image_url = ?, 
                    updated_at = ?
                WHERE id = ?";
        return $this->db->executePrepared($sql, [
            $data['name'],
            $data['description'],
            $data['selling_price'],
            $data['stock_quantity'],
            $data['chude_id'],
            $data['trangthai_id'],
            $data['warranty_days'],
            $data['image_url'],
            $data['updated_at'],
            $data['id']
        ]);
    }

    public function updateQuanity($id, $quantity) {
        $sql = "UPDATE sanpham SET stock_quantity = ? WHERE id = ?";
        return $this->db->executePrepared($sql, [$quantity, $id]);
    }

    // search
    public function getTotalSearchSanPham($search) {
        $sql = "SELECT COUNT(*) as total FROM sanpham 
                WHERE id LIKE ? OR LOWER(name) LIKE ?";
        $searchParam = "%$search%";
        $result = $this->db->executePrepared($sql, [$searchParam, $searchParam]);
        return $result->fetch_assoc()['total'];
    }

    public function searchSanPham($search, $limit, $offset) {
        $sql = "SELECT * FROM sanpham 
                WHERE id LIKE ? OR LOWER(name) LIKE ?
                LIMIT ? OFFSET ?";
        $searchParam = "%$search%";
        $result = $this->db->executePrepared($sql, [$searchParam, $searchParam, $limit, $offset]);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // filter
    public function filterSanPham($filter, $limit, $offset) {
        $sql = "SELECT * FROM sanpham 
            WHERE selling_price BETWEEN ? AND ?";

        $params = [
            $filter['min_price'],
            $filter['max_price']
        ];

        if (!empty($filter['chude_id'])) {
            $sql .= " AND chude_id = ?";
            $params[] = $filter['chude_id'];
        }
        if (!empty($filter['trangthai_id'])) {
            $sql .= " AND trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }

        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $sql .= " AND updated_at BETWEEN ? AND ?";
            $params[] = $filter['start_date'];
            $params[] = $filter['end_date'];
        }

        $sql .= " LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;

        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalFilterSanPham($filter) {
        $sql = "SELECT COUNT(*) as total FROM sanpham 
                WHERE selling_price BETWEEN ? AND ?";

        $params = [
            $filter['min_price'],
            $filter['max_price']
        ];

        if (!empty($filter['chude_id'])) {
            $sql .= " AND chude_id = ?";
            $params[] = $filter['chude_id'];
        }
        if (!empty($filter['trangthai_id'])) {
            $sql .= " AND trangthai_id = ?";
            $params[] = $filter['trangthai_id'];
        }

        if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
            $sql .= " AND updated_at BETWEEN ? AND ?";
            $params[] = $filter['start_date'];
            $params[] = $filter['end_date'];
        }
         
        $result = $this->db->executePrepared($sql, $params);
        return $result->fetch_assoc()['total'];
    }
}
?>