<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/sanPham.js?v=<?= time() ?>"></script>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchProduct" placeholder="Tìm kiếm sản phẩm...">
            </div>
            <button id="filterProduct" class="btn filter-btn">
                <i class="fa-solid fa-filter"></i>
                <span>Lọc</span>
            </button>
        </div>
        <button id="addProduct" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm sản phẩm</span>
        </button>
    </div>

    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thể loại</th>
                    <th>Trạng thái</th>
                    <th>Ngày cập nhật</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="productList">

            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>

</body>
</html>