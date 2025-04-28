<?php
require_once '../model/phieuNhap.model.php';
require_once '../model/sanPham.model.php';
require_once '../model/nhaCungCap.model.php';
require_once '../model/sanPham.model.php';
require_once "./nguoiDung.controller.php";
require_once "./nhaCungCap.controller.php";
require_once "./sanPham.controller.php";

class PhieuNhapController {
    private $phieuNhapModel;
    private $sanPhamController;
    private $sanPhamModel;
    private $nhaCungCapModel;
    private $nguoiDungController;

    public function __construct() {
        $this->phieuNhapModel = new PhieuNhapModel();
        $this->nhaCungCapModel = new NhaCungCapModel();
        $this->nguoiDungController = new NguoiDungController();
        $this->sanPhamController = new SanPhamController();
        $this->sanPhamModel = new SanPhamModel();
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

    public function listCTPhieuNhap($id) {
        $ctPhieuNhaps = $this->phieuNhapModel->getCTPhieuNhapById($id);
        
        foreach ($ctPhieuNhaps as &$ctPhieuNhap) {
            $sanPhamName = $this->sanPhamController->getNameById($ctPhieuNhap['sanpham_id']);
            $ctPhieuNhap['sanpham_name'] = $sanPhamName;
        }

        echo json_encode([
            'ctPhieuNhaps' => $ctPhieuNhaps
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
                $this->phieuNhapModel->addChiTietPhieuNhap([
                    'phieunhap_id' => $phieuNhapId,
                    'sanpham_id' => $sp['id'],
                    'quantity' => $sp['quantity'],
                    'price' => $sp['price'],
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
                'message' => 'Có lỗi xảy ra khi thêm phiếu nhập'
            ]);
        }
    }

    public function updateStatusPhieuNhap($id) {
        $currentStatus = $this->phieuNhapModel->getPhieuNhapById($id)['trangthai_id'];
        
        if ($currentStatus == 8) { // nếu phiếu nhập đang giao 
            $ctPhieuNhaps = $this->phieuNhapModel->getCTPhieuNhapById($id);
            foreach ($ctPhieuNhaps as $ct) {
                // Lấy thông tin sản phẩm hiện tại
                $sanPham = $this->sanPhamModel->getSanPhamById($ct['sanpham_id']);
                
                // Cập nhật số lượng
                $newStock = $sanPham['stock_quantity'] + $ct['quantity'];
                $this->sanPhamModel->updateQuanity($ct['sanpham_id'], $newStock);
                
                // Tính giá bán mới từ giá nhập và lợi nhuận
                $giaBanMoi = $ct['price'] + ($ct['price'] * $ct['profit'] / 100);
                
                // So sánh với giá bán hiện tại
                if ($giaBanMoi > $sanPham['selling_price']) {
                    // Cập nhật giá bán mới
                    $this->sanPhamModel->updateSellingPrice($ct['sanpham_id'], $giaBanMoi);
                }
            }
        }

        $status = $currentStatus + 1;
        $result = $this->phieuNhapModel->updateStatusPhieuNhap($id, $status);

        echo json_encode(["success" => $result]);
    }

}

if (isset($_GET['action'])) {
    $controller = new PhieuNhapController();
    switch ($_GET['action']) {
        case 'listPhieuNhap':
            $controller->listPhieuNhap($_GET['status'], $_GET['limit']);
            break;
        case 'listCTPhieuNhap':
            $controller->listCTPhieuNhap($_GET['id']);
            break;
    }
}

if (isset($_POST['action'])) {
    $controller = new PhieuNhapController();
    
    switch ($_POST['action']) {
        case 'addPhieuNhap':
            $controller->addPhieuNhap($_POST);
            break;
        case 'updateStatusPhieuNhap':
            $controller->updateStatusPhieuNhap($_POST['id']);
            break;
    }
}
?>