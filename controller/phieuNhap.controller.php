<?php
require_once '../model/phieuNhap.model.php';
require_once '../model/sanPham.model.php';
require_once '../model/nhaCungCap.model.php';
require_once "./nguoiDung.controller.php";
require_once "./nhaCungCap.controller.php";

class PhieuNhapController {
    private $phieuNhapModel;
    private $sanPhamModel;
    private $nhaCungCapModel;
    private $nguoiDungController;
    private $nhaCungCapController;

    public function __construct() {
        $this->phieuNhapModel = new PhieuNhapModel();
        $this->sanPhamModel = new SanPhamModel();
        $this->nhaCungCapModel = new NhaCungCapModel();
        $this->nguoiDungController = new NguoiDungController();
        $this->nhaCungCapController = new NhaCungCapController();
    }

    public function convertStatus($status) {
        switch ($status) {
            case 'chuaXuLy':
                $status = 6;
                break;
            case 'dangXuLy':
                $status = 7;
                break;
            case 'dangGiao':
                $status = 8;
                break;
            case 'daGiao':
                $status = 9;
                break;
            case 'daHuy':
                $status = 10;
                break;
        }
        return $status;
    }

    public function listPhieuNhap($status, $limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $status = $this->convertStatus($status);

        $phieuNhaps = $this->phieuNhapModel->getPhieuNhaps($status, $limit, $offset);
        $totalPhieuNhap = $this->phieuNhapModel->getTotalPhieuNhaps($status);
        $totalPages = ceil($totalPhieuNhap / $limit);
        
        foreach ($phieuNhaps as &$phieuNhap) {
            $nhaCungCapName = $this->nhaCungCapModel->getNameById($phieuNhap['nhacungcap_id']);
            $phieuNhap['nhacungcap_name'] = $nhaCungCapName;
       
            $nguoiTaoName = $this->nguoiDungController->getFullNameById($phieuNhap['nguoidung_id']);
            $phieuNhap['nguoitao_name'] = $nguoiTaoName;
        }

        echo json_encode([
            'success' => true,
            'message' => 'Lấy danh sách phiếu nhập thành công',
            'phieuNhaps' => $phieuNhaps,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ]);
    }

    public function addPhieuNhap($data) {
        // Validate dữ liệu
        if (!isset($data['nhaCungCap']) || !isset($data['nguoiTao']) || empty($data['sanPhamList'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ'
            ]);
            return;
        }

        // Thêm phiếu nhập
        $result = $this->phieuNhapModel->addPhieuNhap([
            'nhacungcap_id' => $data['nhaCungCap'],
            'nguoidung_id' => $data['nguoiTao'],
            'date' => date('Y-m-d H:i:s'),
            'trangthai_id' => 6, 
            'total_amount' => $data['tongTien']
        ]);

        if ($result) {
            $phieuNhapId = $this->phieuNhapModel->getLastInsertId();

            // Thêm chi tiết phiếu nhập
            foreach ($data['sanPhamList'] as $sp) {
                $donGia = $this->sanPhamModel->getSanPhamById($sp['id'])['selling_price'];
                $this->phieuNhapModel->addChiTietPhieuNhap([
                    'phieunhap_id' => $phieuNhapId,
                    'sanpham_id' => $sp['id'],
                    'quantity' => $sp['quantity'],
                    'price' => $donGia,
                    'profit' => $sp['profit']
                ]);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Thêm phiếu nhập thành công'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ]);
        }
    }

}

if (isset($_GET['action'])) {
    $controller = new PhieuNhapController();
    switch ($_GET['action']) {
        case 'listPhieuNhap':
            $controller->listPhieuNhap($_GET['status'], $_GET['limit']);
            break;
    }
}

if (isset($_POST['data'])) {
    $controller = new PhieuNhapController();
    $data = $_POST['data'];
    
    switch ($data['action']) {
        case 'addPhieuNhap':
            $controller->addPhieuNhap($data);
            break;
    }
}
?>