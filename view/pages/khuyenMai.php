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
            <button id="filterKhuyenMai" class="btn filter-btn">
                <i class="fa-solid fa-filter"></i>
                <span>Lọc</span>
            </button>
        </div>
        <button id="addKhuyenMai" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm khuyến mãi</span>
        </button>
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
                    <label for="code">Mã khuyến mãi:</label>
                    <input type="text" id="code" name="code" required>
                </div>
                <div class="form-group">
                    <label for="profit">Giá trị:</label>
                    <input type="text" id="profit" name="profit" required>
                </div>
                <div class="form-group">
                    <label for="type">Loại:</label>
                    <input type="text" id="type" name="type" required>
                </div>


                <div class="form-group">
                <label for="startDate">Ngày bắt đầu:</label>
                <input type="text" id="startDate" name="startDate" placeholder="Nhấp vào để mở lịch chọn ngày" required>
            </div>


            <div class="form-group">
                    <label for="endDate">Ngày kết thúc:</label>
                    <input type="text" id="endDate" name="endDate" placeholder="Nhấp vào để mở lịch chọn ngày" required>
                </div>

                
            
            <script>    
                flatpickr("#startDate", {
                    enableTime: true,
                    time_24hr: true,
                    enableSeconds: true,
                    dateFormat: "Y-m-d H:i:S"
                });

                flatpickr("#endDate", {
                    enableTime: true,
                    time_24hr: true,
                    enableSeconds: true,
                    dateFormat: "Y-m-d H:i:S"
                });
            </script>


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