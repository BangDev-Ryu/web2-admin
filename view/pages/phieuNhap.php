<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/phieuNhap.js?v=<?php echo time(); ?>"></script>
</head>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchPhieuNhap" placeholder="Tìm kiếm phiếu nhập...">
            </div>
        </div>
        <button id="addPhieuNhap" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm phiếu nhập</span>
        </button>
        
    </div>

    <div class="tab-section">
        <div class="tab-item" data-status="chuaXuLy">
            Chưa xử lý
        </div>
        <div class="tab-item" data-status="dangXuLy">
            Đang xử lý
        </div>
        <div class="tab-item" data-status="dangGiao">
            Đang giao
        </div>
        <div class="tab-item" data-status="daGiao">
            Đã giao
        </div>
        <div class="tab-item" data-status="daHuy">
            Đã hủy
        </div>
    </div>

    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nhà cung cấp</th>
                    <th>Người nhập</th>
                    <th>Ngày nhập</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="phieuNhapList">

            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>
</body>
</html>