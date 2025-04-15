<?php
require_once '../model/phieuNhap.model.php';
require_once "./nguoiDung.controller.php";
require_once "./nhaCungCap.controller.php";

class PhieuNhapController {
    private $phieuNhapModel;
    private $nguoiDungController;
    private $nhaCungCapController;

    public function __construct() {
        $this->phieuNhapModel = new PhieuNhapModel();
        $this->nguoiDungController = new NguoiDungController();
        $this->nhaCungCapController = new NhaCungCapController();
    }

    public function listPhieuNhap($status, $limit) {
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

        $phieuNhaps = $this->phieuNhapModel->getPhieuNhaps($status, $limit, $offset);
        $totalPhieuNhap = $this->phieuNhapModel->getTotalPhieuNhaps($status);
        $totalPages = ceil($totalPhieuNhap / $limit);
        
        foreach ($phieuNhaps as &$phieuNhap) {
            $nhaCungCapName = $this->nhaCungCapController->getNameById($phieuNhap['nhacungcap_id']);
            $phieuNhap['nhacungcap_name'] = $nhaCungCapName;

            $nguoiDungName = $this->nguoiDungController->getFullNameById($phieuNhap['nguoidung_id']);
            $phieuNhap['nguoidung_name'] = $nguoiDungName;
        }

        echo json_encode([
            "phieuNhaps" => $phieuNhaps,
            "totalPages" => $totalPages,
            "currentPage" => $page
        ]);
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
?>