<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/table.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/actions.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/modal.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/phieuNhap.css?v=<?php echo time(); ?>">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/phieuNhap.js?v=<?php echo time(); ?>"></script>
</head>
</head>
<body>
    <div class="table-actions">
        <div class="search-section">
            <div class="search-box">
                <input type="text" id="searchPhieuNhap" placeholder="Tìm kiếm phiếu nhập...">
            </div>
        </div>
        <button id="addPhieuNhap" class="btn add-btn">
            <i class="fa-solid fa-plus"></i>
            <span>Thêm phiếu nhập</span>
        </button>
        
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
                    <th>Nhà cung cấp</th>
                    <th>Người nhập</th>
                    <th>Ngày nhập</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>

            <tbody id="phieuNhapList">

            </tbody>
        </table>
    </div>

    <div id="pagination">

    </div>

    <div class="modal" id="phieuNhapModal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2 id="modalTitle">Thêm phiếu nhập</h2>

            <div class="phieuNhap-container">
                <!-- Cột trái -->
                <div class="phieuNhap-left">
                    <div class="phieuNhap-info">
                        <div class="form-group">
                            <label for="nhaCungCap">Nhà cung cấp:</label>
                            <select id="nhaCungCap" required>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Người tạo:</label>
                            <span id="nguoiTao"></span>
                        </div>

                        <div class="form-group">
                            <label>Ngày tạo:</label>
                            <span id="ngayTao"></span>
                        </div>
                    </div>

                    <div class="ctPhieuNhap-data">
                        <table id="ctPhieuNhapTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Đơn giá</th>
                                    <th>Lợi nhuận</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="ctPhieuNhapList">
                            </tbody>
                        </table>
                        
                        <div class="total-amount">
                            <strong>Tổng tiền:</strong>
                            <span id="tongTien">0đ</span>
                        </div>
                    </div>
                </div>

                <!-- Cột phải -->
                <div class="phieuNhap-right">
                    <div class="sanPham-content">
                        <!-- <h3>Danh sách sản phẩm</h3> -->
                        <div class="sanPham-search">
                            <input type="text" id="searchSanPhamTable" placeholder="Tìm kiếm sản phẩm theo id hoặc tên">
                        </div>
                        <table id="sanPhamTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Đơn giá</th>
                                    <th>Số lượng tồn</th>
                                </tr>
                            </thead>
                            <tbody id="sanPhamList">
                            </tbody>
                        </table>

                        <div class="sanPham-actions">
                            <div class="product-controls">
                                <div class="form-group">
                                    <label for="sanPhamProfit">Lợi nhuận:</label>
                                    <div class="profit-control">
                                        <input type="range" id="sanPhamProfit" min="0" max="100" value="0" step="1">
                                        <span id="profitValue">0%</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sanPhamQuantity">Số lượng:</label>
                                    <input type="number" id="sanPhamQuantity" min="1" value="1">
                                </div>

                                <button id="addSanPham" class="btn add-btn">
                                    <i class="fa-solid fa-plus"></i>
                                    <span>Thêm sản phẩm</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-actions">
                <button class="btn" id="createPhieuNhap">Tạo phiếu nhập</button>
                <button class="btn" id="closeModal">Đóng</button>
            </div>
        </div>
    </div>
</body>
</html>