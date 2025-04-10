<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">

    <script src="./js/nhaCungCap.js?v=<?= time() ?>"></script>
</head>
<body>
<div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchNhaCungCap" placeholder="Tìm kiếm nhà cung cấp...">
            </div>
        </div>
        <button id="addNhaCungCap" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm nhà cung cấp</span>
        </button>
    </div>

    <div class="filter-nhaCungCapsection">
    <div class="filter-nhaCungCaprow">
        <div class="filter-nhaCungCapgroup">
            <label>Trạng thái:</label>
            <select id="trangThaiFilter">
            </select>
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
                    <th>Tên nhà cung cấp</th>
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

    <div class="modal" id="nhaCungCapModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm nhà cung cấp</h2>
            <form id="nhaCungCapForm">
                <input type="hidden" id="nhaCungCapId">
                <div class="form-group">
                    <label for="nhaCungCap-name">Tên nhà cung cấp:</label>
                    <input type="text" id="nhaCungCap-name" name="nhaCungCap-name" required>
                </div>
                <div class="form-group">
                    <label for="contact-person">Người liên hệ:</label>
                    <input type="text" id="contact-person" name="contact-person" required>
                </div>
                <div class="form-group">
                    <label for="contact-email">Email:</label>
                    <input type="text" id="contact-email" name="contact-email" required>
                </div>
                <div class="form-group">
                    <label for="contact-phone">Số điện thoại:</label>
                    <input type="text" id="contact-phone" name="contact-phone" required>
                </div>
                <div class="form-group">
                    <label for="contact-email">Địa chỉ:</label>
                    <input type="text" id="address" name="address" required>
                </div>
                <div class="form-group">
                    <label for="nhaCungCap-trangThai">Trạng thái:</label>
                    <select id="nhaCungCap-trangThai" name="nhaCungCap-trangThai" required>

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
            <p>Bạn có chắc chắn muốn xóa nhà cung cấp này?</p>
            <div class="form-actions">
                <button id="confirmDelete" class="btn confirm-delete-btn">Xóa</button>
                <button class="btn cancel-btn">Hủy</button>
            </div>
        </div>
    </div>
</body>
</html>