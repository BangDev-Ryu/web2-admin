<?php
require_once '../model/donHang.model.php';
require_once "./trangThai.controller.php";
require_once "./nguoiDung.controller.php";

class DonHangController {
    private $donHangModel;
    private $trangThaiController;
    private $nguoiDungController;

    public function __construct() {
        $this->donHangModel = new DonHangModel();
        $this->trangThaiController = new TrangThaiController();
        $this->nguoiDungController = new NguoiDungController();
    }

    public function listDonHang($limit) {
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $donHangs = $this->donHangModel->getDonHangs($limit, $offset);
        $totalDonHang = $this->donHangModel->getTotalDonHangs();
        $totalPages = ceil($totalDonHang / $limit);
        
        foreach ($donHangs as &$donHang) {
            $nguoiDungName = $this->nguoiDungController->getFullNameById($donHang['nguoidung_id']);
            $trangThaiName = $this->trangThaiController->getNameById($donHang['trangthai_id']);
            $donHang['nguoidung_name'] = $nguoiDungName;
            $donHang['trangthai_name'] = $trangThaiName;

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
            $controller->listDonHang($_GET['limit']);
            break;
    }
}
?>