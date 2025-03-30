<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">

    <script src="./js/nhaCungCap.js?v=<?= time() ?>"></script>
</head>
<body>
<div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchNhaCungCap" placeholder="Tìm kiếm nhà cung cấp...">
            </div>
            <button id="filterNhaCungCap" class="btn filter-btn">
                <i class="fa-solid fa-filter"></i>
                <span>Lọc</span>
            </button>
        </div>
        <button id="addNhaCungCap" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm nhà cung cấp</span>
        </button>
    </div>

    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Người liên hệ</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="nhaCungCapList">

            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>
</body>
</html>