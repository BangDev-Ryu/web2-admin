<?php
require_once '../model/donHang.model.php';
require_once '../model/sanPham.model.php';
require_once '../model/khuyenMai.model.php';
require_once "./nguoiDung.controller.php";
require_once "./sanPham.controller.php";

class DonHangController {
    private $donHangModel;
    private $nguoiDungController;
    private $sanPhamController;
    private $sanPhamModel;
    private $khuyenMaiModel;
    private $nguoiDungModel;

    public function __construct() {
        $this->donHangModel = new DonHangModel();
        $this->nguoiDungController = new NguoiDungController();
        $this->sanPhamController = new SanPhamController();
        $this->sanPhamModel = new SanPhamModel();
        $this->nguoiDungModel = new NguoiDungModel();
        $this->khuyenMaiModel = new KhuyenMaiModel();
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

    public function listDonHang($status, $limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
        $status = $this->convertStatus($status);

        $donHangs = $this->donHangModel->getDonHangs($status, $limit, $offset);
        $totalDonHang = $this->donHangModel->getTotalDonHangs($status);
        $totalPages = ceil($totalDonHang / $limit);
        
        foreach ($donHangs as &$donHang) {
            $nguoiDungName = $this->nguoiDungController->getFullNameById($donHang['nguoidung_id']);
            $donHang['nguoidung_name'] = $nguoiDungName;

            if ($donHang['khuyenmai_id'] === null) {
                $donHang['khuyenmai_name'] = "Không có";
            }
            else {
                $donHang['khuyenmai_name'] = $this->khuyenMaiModel->getKhuyenMaiById($donHang['khuyenmai_id'])['name'];
            }
        }

        echo json_encode([
            "donHangs" => $donHangs,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function listDonHangByFilter($status, $limit, $filter) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $filter = isset($_GET['filter']) ? $filter : [];
        $status = $this->convertStatus($status);
        $donHangs = $this->donHangModel->filterDonHang($status, $filter, $limit, $offset);
        $totalDonHangs = $this->donHangModel->getTotalFilterDonHang($status, $filter);
        $totalPages = ceil($totalDonHangs / $limit);

        foreach ($donHangs as &$donHang) {
            $nguoiDungName = $this->nguoiDungController->getFullNameById($donHang['nguoidung_id']);
            $donHang['nguoidung_name'] = $nguoiDungName;

            if ($donHang['khuyenmai_id'] === null) {
                $donHang['khuyenmai_name'] = "Không có";
            }
        }

        echo json_encode([
            "donHangs" => $donHangs,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
    }

    public function listCTDonHang($id) {
        $ctDonHangs = $this->donHangModel->getCTDonHangById($id);
        foreach ($ctDonHangs as &$ct) {
            $sanPhamName = $this->sanPhamController->getNameById($ct['sanpham_id']);
            $ct['sanpham_name'] = $sanPhamName;
        }
        
        echo json_encode(["ctDonHangs" => $ctDonHangs]);
    }

    public function updateStatusDonHang($id) {
        $currentStatus = $this->donHangModel->getDonHangStatus($id);
        if ($currentStatus == 6) { // nếu đơn hàng chưa xử lý
            $ctDonHangs = $this->donHangModel->getCTDonHangById($id);
            foreach ($ctDonHangs as $ct) {
                $sanPham = $this->sanPhamModel->getSanPhamById($ct['sanpham_id']);
                $newStock = $sanPham['stock_quantity'] - $ct['quantity'];
                if ($newStock < 0) {
                    echo json_encode([
                        "success" => false, 
                        "message" => "Sản phẩm " . $sanPham['name'] . " không đủ số lượng"
                    ]);
                    return;
                }
                $this->sanPhamModel->updateQuanity($ct['sanpham_id'], $newStock);
            }
        }

        $status = $currentStatus + 1;
        $result = $this->donHangModel->updateStatusDonHang($id, $status);
        echo json_encode(["success" => $result]);
    }

    public function getTop5NguoiDungs($startDate, $endDate) {
        $customers = $this->donHangModel->getTop5NguoiDungs($startDate, $endDate);
        
        foreach ($customers as &$customer) {
            $customer['name'] = $this->nguoiDungModel->getFullNameById($customer['id']);
        }

        echo json_encode(['customers' => $customers]);
    }

    public function getDonHangNguoiDung($nguoiDungId, $startDate, $endDate) {
        $orders = $this->donHangModel->getDonHangNguoiDung($nguoiDungId, $startDate, $endDate);
        echo json_encode(['orders' => $orders]);
    }

    public function getTop5Products($startDate, $endDate) {
        $products = $this->donHangModel->getTop5Products($startDate, $endDate);
        
        foreach ($products as &$product) {
            $product['name'] = $this->sanPhamModel->getTenSanPhamById($product['id']);
        }

        echo json_encode(['products' => $products]);
    }

    public function getTop5CustomersByCity($startDate, $endDate, $city) {
        $customers = $this->donHangModel->getTop5CustomersByCity($startDate, $endDate, $city);
        
        foreach ($customers as &$customer) {
            $customer['name'] = $this->nguoiDungModel->getFullNameById($customer['id']);
        }        

        echo json_encode(['customers' => $customers]);
    }
}

if (isset($_GET['action'])) {
    $controller = new DonHangController();
    switch ($_GET['action']) {
        case 'listDonHang':
            $controller->listDonHang($_GET['status'], $_GET['limit']);
            break;
        case 'listCTDonHang':
            $controller->listCTDonHang($_GET['id']);
            break;
        case 'getTop5NguoiDungs':
            $controller->getTop5NguoiDungs($_GET['startDate'], $_GET['endDate']);
            break;
        case 'getDonHangNguoiDung':
            $controller->getDonHangNguoiDung($_GET['nguoiDungId'], $_GET['startDate'], $_GET['endDate']);
            break;
        case 'listDonHangByFilter':
            $controller->listDonHangByFilter($_GET['status'], $_GET['limit'], $_GET['filter']);
            break;
        case 'getTop5Products':
            $controller->getTop5Products($_GET['startDate'], $_GET['endDate']);
            break;
        case 'getTop5CustomersByCity':
            $controller->getTop5CustomersByCity($_GET['startDate'], $_GET['endDate'], $_GET['city']);
            break;
    }
}

if (isset($_POST['action'])) {
    $controller = new DonHangController();
    switch ($_POST['action']) {
        case 'updateStatusDonHang':
            $controller->updateStatusDonHang($_POST['id']);
            break;
    }
}
?>