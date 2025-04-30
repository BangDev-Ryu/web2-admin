<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/donHang.js?v=<?php echo time(); ?>"></script>
</head>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchDonHang" placeholder="Tìm kiếm đơn hàng...">
            </div>
        </div>
        
    </div>

    <div class="filter-section">

        <div class="filter-row">
            

            <div class="filter-group">
                <label>Thành phố:</label>
                <select id="thanhPhoFilter">
                </select>
            </div>

            <div class="filter-group">
                <label>Quận:</label>
                <select id="quanFilter">
                </select>
            </div>
            
            <div class="filter-group">
                <label>Huyện/phường:</label>
                <select id="huyenPhuongFilter">
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

    <div class="tab-section">
        <div class="tab-item" data-status="chuaXuLy">
            Chưa xử lý
        </div>
        <div class="tab-item" data-status="dangXuLy">
            Đang xử lý
        </div>
        <div class="tab-item" data-status="dangGiao">
            Đang giao
        </div>
        <div class="tab-item" data-status="daGiao">
            Đã giao
        </div>
        <div class="tab-item" data-status="daHuy">
            Đã hủy
        </div>
    </div>

    <div class="table-content">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Người mua</th>
                    <th>Số nhà</th>
                    <th>Thành phố</th>
                    <th>Quận</th>
                    <th>Huyện/Phường</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Khuyến mãi</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="donHangList">

            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>

    <div class="modal" id="donHangModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Chi tiết đơn hàng</h2>

            <div class="table-content">
                <table>
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                        </tr>
                    </thead>

                    <tbody id="ctDonHangList">

                    </tbody>
                </table>
            </div>

            <div class="modal-actions">
                <button class="btn" id="updateDonHang">Duyệt đơn hàng</button>
                <button class="btn" id="closeModal">Đóng</button>
            </div>
        </div>
    </div>
</body>
</html>