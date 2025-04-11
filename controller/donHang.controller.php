<?php
require_once '../model/donHang.model.php';
require_once "./nguoiDung.controller.php";

class DonHangController {
    private $donHangModel;
    private $nguoiDungController;

    public function __construct() {
        $this->donHangModel = new DonHangModel();
        $this->nguoiDungController = new NguoiDungController();
    }

    public function listDonHang($status, $limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;
        
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

        $donHangs = $this->donHangModel->getDonHangs($status, $limit, $offset);
        $totalDonHang = $this->donHangModel->getTotalDonHangs($status);
        $totalPages = ceil($totalDonHang / $limit);
        
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

}

if (isset($_GET['action'])) {
    $controller = new DonHangController();
    switch ($_GET['action']) {
        case 'listDonHang':
            $controller->listDonHang($_GET['status'], $_GET['limit']);
            break;
    }
}
?>