<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/theLoai.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/theLoai.js?v=<?= time() ?>"></script>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchCategory" placeholder="Tìm kiếm thể loại...">
            </div>
            <button id="filterCategory" class="btn">
                <i class="fa-solid fa-filter"></i>
                <span>Lọc</span>
            </button>
        </div>
        <button id="addCategory" class="btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm thể loại</span>
        </button>
    </div>

    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên thể loại</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="theLoaiList">
            </tbody>
        </table>
    </div>

    <div id="pagination"></div>
</body>
</html>