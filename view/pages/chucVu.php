<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/chucVu.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./assets/fonts/fontawesome/css/all.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/chucVu.js?v=<?php echo time(); ?>"></script>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchChucVu" placeholder="Tìm kiếm chức vụ...">
            </div>
        </div>
        <button id="addChucVu" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm chức vụ</span>
        </button>
    </div>

    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên chức vụ</th>
                    <th>Mô tả</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="chucVuList">

            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>

    <div class="modal" id="chucVuModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm chức vụ</h2>
            <form id="chucVuForm">
                <input type="hidden" id="chucVuId">
                <div class="form-group">
                    <label for="chucVu-name">Tên chức vụ:</label>
                    <input type="text" id="chucVu-name" name="chucVu-name" required>
                </div>
                <div class="form-group">
                    <label for="chucVu-description">Mô tả:</label>
                    <textarea id="chucVu-description" name="chucVu-description"></textarea>
                </div>

                <div class="permissions-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Chức năng</th>
                                <th>Xem</th>
                                <th>Thêm</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        
                        <tbody id="quyenList">
                            
                        </tbody>
                    </table>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn save-btn">Lưu</button>
                    <button type="button" class="btn cancel-btn">Hủy</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>