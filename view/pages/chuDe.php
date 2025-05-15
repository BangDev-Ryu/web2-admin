<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">


    <script src="./js/chuDe.js?v=<?= time() ?>"></script>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchChuDe" placeholder="Tìm kiếm chủ đề...">
            </div>
        </div>
        <button id="addChuDe" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm chủ đề</span>
        </button>
    </div>

    <!-- <div class="filter-chuDesection">
        <div class="filter-chuDerow">
            <div class="filter-group">
                <label>Thể loại:</label>
                <select id="theLoaiFilter">
                </select>
            </div>

            <div class="filter-group">
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
                    <th>Tên chủ đề</th>
                    <th>Thể loại</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="chuDeList">
            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>

    <div class="modal" id="chuDeModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm chủ đề</h2>
            <form id="chuDeForm">
                <input type="hidden" id="chuDeId">
                <div class="form-group">
                    <label for="chuDe-name">Tên chủ đề:</label>
                    <input type="text" id="chuDe-name" name="chuDe-name" required>
                </div>
                <div class="form-group">
                    <label for="chuDe-theLoai">Thể loại:</label>
                    <select id="chuDe-theLoai" name="chuDe-theLoai" required>

                    </select>
                </div>
                <div class="form-group">
                    <label for="chuDe-trangThai">Trạng thái:</label>
                    <select id="chuDe-trangThai" name="chuDe-trangThai" required>

                    </select>
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
            <p>Bạn có chắc chắn muốn xóa chủ đề này?</p>
            <div class="form-actions">
                <button id="confirmDelete" class="btn confirm-delete-btn">Xóa</button>
                <button class="btn cancel-btn">Hủy</button>
            </div>
        </div>
    </div>
</body>
</html>