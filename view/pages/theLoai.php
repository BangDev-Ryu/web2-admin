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
    <script src="./js/theLoai.js?v=<?php echo time(); ?>"></script>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchTheLoai" placeholder="Tìm kiếm thể loại...">
            </div>
        </div>
        <button id="addTheLoai" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm thể loại</span>
        </button>
    </div>
    
    <!-- <div class="filter-Mirylsection">
    <div class="filter-Mirylrow">
        <div class="filter-Mirylgroup">
            <label>Trạng thái:</label>
            <select id="trangThaiFilter">
            </select>
        </div>
    </div>

    <div class="filter-actions">
        <button class="btn" id="resetFilter">Đặt lại</button>
        <button class="btn save-btn" id="applyFilter">Áp dụng</button>
    </div>
</div> -->

    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên thể loại</th>
                    <th>Mô tả</th>
                    <!-- <th>Trạng thái</th> -->
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="theLoaiList">
            </tbody>
        </table>
    </div>

    <div id="pagination"></div>

    <!-- Modal Thêm/Sửa Thể Loại -->
    <div class="modal" id="theLoaiModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm Thể Loại</h2>
            <form id="theLoaiForm">
                <input type="hidden" id="theLoaiId">
                <div class="form-group">
                    <label for="theLoai-name">Tên thể loại:</label>
                    <input type="text" id="theLoai-name" name="theLoai-name" required>
                </div>
                <div class="form-group">
                    <label for="theLoai-description">Mô tả:</label>
                    <textarea id="theLoai-description" name="theLoai-description"></textarea>
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
            <p>Bạn có chắc chắn muốn xóa thể loại này?</p>
            <div class="form-actions">
                <button id="confirmDeleteTheLoai" class="btn confirm-delete-btn">Xóa</button>
                <button class="btn cancel-btn">Hủy</button>
            </div>
        </div>
    </div>
</body>
</html>