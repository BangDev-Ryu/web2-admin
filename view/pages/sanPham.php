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
    <script src="./js/sanPham.js?v=<?php echo time(); ?>"></script>
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

    <div class="filter-section">

        <div class="filter-row">
            <div class="filter-group">
                <label>Chức vụ:</label>
                <select id="chucVuFilter">
                </select>
            </div>

            <div class="filter-group">
                <label>Trạng thái:</label>
                <select id="trangThaiFilter">
                </select>
            </div>

            <div class="filter-group">
                <label>Loại tài khoản</label>
                <select id="loaiTKFilter">
                </select>
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
                    <th>Chủ đề</th>
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

    <div class="modal" id="sanPhamModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm sản phẩm</h2>
            <form id="sanPhamForm" enctype="multipart/form-data">
                <input type="hidden" id="sanPhamId">
                <div class="form-group">
                    <label for="sanPham-name">Tên sản phẩm:</label>
                    <input type="text" id="sanPham-name" name="sanPham-name" required>
                </div>
                <div class="form-group">
                    <label for="sanPham-description">Mô tả:</label>
                    <textarea id="sanPham-description" name="sanPham-description"></textarea>
                </div>
                <div class="form-group">
                    <label for="sanPham-price">Giá bán:</label>
                    <input type="number" id="sanPham-price" name="sanPham-price" required>
                </div>
                <div class="form-group">
                    <label for="sanPham-quantity">Số lượng:</label>
                    <input type="number" id="sanPham-quantity" name="sanPham-quantity" required>
                </div>
                <div class="form-group">
                    <label for="sanPham-chuDe">Chủ đề</label>
                    <select id="sanPham-chuDe" name="sanPham-chuDe" required>

                    </select>
                </div>
                <div class="form-group">
                    <label for="sanPham-trangThai">Trạng thái:</label>
                    <select id="sanPham-trangThai" name="sanPham-trangThai" required>

                    </select>
                </div>
                <div class="form-group">
                    <label for="sanPham-warranty">Ngày bảo hành:</label>
                    <input type="number" id="sanPham-warranty" name="sanPham-warranty" required>
                </div>
                <div class="form-group">
                    <label for="sanPham-image">Hình ảnh sản phẩm:</label>
                    <div class="file-upload">
                        <input type="file" id="sanPham-image" name="sanPham-image">
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
            <p>Bạn có chắc chắn muốn xóa sản phẩm này?</p>
            <div class="form-actions">
                <button id="confirmDeleteSanPham" class="btn confirm-delete-btn">Xóa</button>
                <button class="btn cancel-btn">Hủy</button>
            </div>
        </div>
    </div>
</body>
</html>