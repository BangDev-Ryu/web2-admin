<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/taiKhoan.js?v=<?php echo time(); ?>"></script>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchTaiKhoan" placeholder="Tìm kiếm tài khoản...">
            </div>
            <button id="filterTaiKhoan" class="btn filter-btn">
                <i class="fa-solid fa-filter"></i>
                <span>Lọc</span>
            </button>
        </div>
        <button id="addTaiKhoan" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm tài khoản</span>
        </button>
    </div>
    
    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Họ tên</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Ngày sinh</th>
                    <th>Loại tài khoản</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="taiKhoanList">
            </tbody>
        </table>
    </div>

    <div id="pagination"></div>

</body>
</html>