<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/sanPham.js?v=<?php echo time() ?>"></script>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchProduct" placeholder="Tìm kiếm sản phẩm...">
            </div>
        </div>
        <button id="addProduct" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm sản phẩm</span>
        </button>
    </div>

    <!-- Khu vực filter mới -->
    <div class="filter-section">
        <div class="filter-group price-filter">
            <label>Khoảng giá:</label>
            <div class="price-range-container">
                <div class="price-range-group">
                    <div class="range-wrapper">
                        <label class="sub-label">Giá từ: <span id="minPriceValue">0đ</span></label>
                        <input type="range" id="minPriceRange" min="0" max="10000000" step="100000" value="0">
                    </div>
                    <div class="range-wrapper">
                        <label class="sub-label">Giá đến: <span id="maxPriceValue">10,000,000đ</span></label>
                        <input type="range" id="maxPriceRange" min="0" max="10000000" step="100000" value="10000000">
                    </div>
                </div>
            </div>
        </div>

        <div class="filter-row">
            <div class="filter-group">
                <label>Thể loại:</label>
                <select id="categoryFilter">
                    <option value="">Tất cả thể loại</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Trạng thái:</label>
                <select id="statusFilter">
                    <option value="">Tất cả trạng thái</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Từ ngày:</label>
                <input type="date" id="startDate">
            </div>

            <div class="filter-group">
                <label>Đến ngày:</label>
                <input type="date" id="endDate">
            </div>
        </div>

        <div class="filter-actions">
            <button class="btn" id="resetFilter">Đặt lại</button>
            <button class="btn save-btn" id="applyFilter">Áp dụng</button>
        </div>
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