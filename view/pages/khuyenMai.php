<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="./js/khuyenMai.js?v=<?= time() ?>"></script>
</head>
<body>
<div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchKhuyenMai" placeholder="Tìm kiếm khuyến mãi...">
            </div>
        </div>
        <button id="addKhuyenMai" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm khuyến mãi</span>
        </button>
    </div>

    <div class="filter-khuyenMaisection">
    <div class="filter-khuyenMairow">
        <div class="filter-khuyenMaigroup">
            <label>Khoảng giá trị:</label> <br>

            <div class="range-row">
                <label class="sub-label">Giá trị từ: <span id="minProfitValue">0đ</span></label>
                <input type="range" id="minProfitRange" min="0" max="10000" step="100" value="0">
            </div>

            <div class="range-row">
                <label class="sub-label">Giá trị đến: <span id="maxProfitValue">10,000</span></label>
                <input type="range" id="maxProfitRange" min="0" max="100000" step="100" value="10000">
            </div>
        </div>
    </div>

    <div class="filter-khuyenMaiactions">
        <button class="btn" id="resetFilter">Đặt lại</button>
        <button class="btn save-btn" id="applyFilter">Áp dụng</button>
    </div>
</div>


    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên khuyến mãi</th>
                    <th>Mã khuyến mãi</th>
                    <th>Giá trị</th>
                    <th>Loại</th>
                    <th>Ngày bắt đầu</th>
                    <th>Ngày kết thúc</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="khuyenMaiList">

            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>

    <div class="modal" id="khuyenMaiModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm khuyến mãi</h2>
            <form id="khuyenMaiForm">
                <input type="hidden" id="khuyenMaiId">
                <div class="form-group">
                    <label for="khuyenMai-name">Tên khuyến mãi:</label>
                    <input type="text" id="khuyenMai-name" name="khuyenMai-name" required>
                </div>
                <div class="form-group">
                    <label for="khuyenMai-code">Mã khuyến mãi:</label>
                    <input type="text" id="khuyenMai-code" name="khuyenMai-code" required>
                </div>
                <div class="form-group">
                    <label for="khuyenMai-profit">Giá trị:</label>
                    <input type="text" id="khuyenMai-profit" name="khuyenMai-profit" required>
                </div>
                <div class="form-group">
                    <label for="khuyenMai-type">Loại:</label>
                    <input type="text" id="khuyenMai-type" name="khuyenMai-type" required>
                </div>


                <div class="form-group">
                <label for="startDate">Ngày bắt đầu:</label>
                <input type="date" id="startDate" name="startDate" required>
            </div>


            <div class="form-group">
                    <label for="endDate">Ngày kết thúc:</label>
                    <input type="date" id="endDate" name="endDate" require>
                </div>

       
                <div class="form-actions">
                    <button type="submit" class="btn save-btn">Lưu</button>
                    <button type="button" class="btn cancel-btn">Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Xác nhận xóa -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <h2>Xác nhận xóa</h2>
            <p>Bạn có chắc chắn muốn xóa khuyến mãi này?</p>
            <div class="form-actions">
                <button id="confirmDelete" class="btn confirm-delete-btn">Xóa</button>
                <button class="btn cancel-btn">Hủy</button>
            </div>
        </div>
    </div>
</body>
</html>