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
                    <th>Chức vụ</th>
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

    <div class="modal" id="taiKhoanModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm Tài Khoản</h2>
            <form id="taiKhoanForm">
                <input type="hidden" id="taiKhoanId">
                <div class="form-group">
                    <label for="fullname">Họ tên:</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="username">Tên đăng nhập:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">SĐT:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Ngày sinh:</label>
                    <input type="date" id="date_of_birth" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label for="chucvu_id">Chức vụ:</label>
                    <select id="chucvu_id" name="chucvu_id" required>
                    </select>
                </div>
                <div class="form-group">
                    <label for="trangthai_id">Trạng thái:</label>
                    <select id="trangthai_id" name="trangthai_id" required>

                    </select>
                </div>
                <div class="form-group">
                    <label for="type_account">Loại tài khoản:</label>
                    <select id="type_account" name="type_account" required>

                    </select>
                    
                </div>
                <div class="form-group">
                    <label for="picture">Hình ảnh:</label>
                    <div class="file-upload">
                        <input type="file" id="picture" name="picture" accept="image/*">
                        <input type="hidden" id="image-base64" name="image-base64">
                        <div class="image-preview">
                            <img id="imagePreview" src="" alt="Preview">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn save-btn">Lưu</button>
                    <button type="button" class="btn cancel-btn">Hủy</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <h2>Xác nhận xóa</h2>
            <p>Bạn có chắc chắn muốn xóa tài khoản này?</p>
            <div class="form-actions">
                <button id="confirmDelete" class="btn confirm-delete-btn">Xóa</button>
                <button class="btn cancel-btn">Hủy</button>
            </div>
        </div>
    </div>

</body>
</html>